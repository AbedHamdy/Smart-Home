<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Exception;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create Stripe Checkout Session
     */
    public function createCheckoutSession(Request $request, $id)
    {
        try
        {
            // جلب الطلب مع بيانات العميل
            $serviceRequest = ServiceRequest::with('client')->find($id);
            
            // التحقق من وجود الطلب
            if (!$serviceRequest) 
            {
                return redirect()->back()->with("error", "Sorry, the service you are trying to access does not exist or has been deleted.");
            }

            // dd($serviceRequest);

            // التحقق من صلاحية الدفع
            if (!$this->canPay($serviceRequest))
            {
                // dd("abed11");
                return back()->with('error', 'Payment is not allowed for this request.');
            }

            // حساب المبلغ الإجمالي
            $total = $this->calculateTotal($serviceRequest);
            // dd($total);

            // التحقق من أن المبلغ أكبر من صفر
            if ($total <= 0)
            {
                return back()->with('error', 'Invalid payment amount.');
            }

            // dd("abed");

            // إنشاء سجل دفع جديد
            $payment = Payment::create([
                'service_request_id' => $serviceRequest->id,
                'user_id' => auth()->id(),
                'amount' => $total,
                'payment_type' => 'full_payment',
                'status' => 'pending',
            ]);

            // إنشاء Stripe Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'egp',
                        'unit_amount' => (int)($total * 100), // تحويل لقروش (أصغر وحدة)
                        'product_data' => [
                            'name' => 'Service Request # ' . $serviceRequest->title,
                            'description' => $serviceRequest->category->name ?? 'Home Service',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('client.stripe.success', ['payment' => $payment->id]),
                'cancel_url' => route('client.stripe.cancel', ['payment' => $payment->id]),
                'customer_email' => $serviceRequest->client->email,
                'metadata' => [
                    'payment_id' => $payment->id,
                    'service_request_id' => $serviceRequest->id,
                    'user_id' => auth()->id(),
                ],
            ]);

            // حفظ Session ID بدلاً من Payment Intent
            $payment->update([
                'stripe_payment_intent_id' => $session->id,
            ]);

            // توجيه المستخدم إلى صفحة الدفع
            return redirect($session->url);
        }
        catch (\Exception $e)
        {
            // تسجيل الخطأ للمراجعة
            // \Log::error('Stripe Payment Error: ' . $e->getMessage());
            
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Payment Success Callback
     */
    public function success(Request $request, $paymentId)
    {
        try {
            // جلب بيانات الدفع
            $payment = Payment::with('serviceRequest')->find($paymentId);

            // dd($payment);
            if (!$payment)
            {
                return redirect()->route('client.service_request.index')->with('error', 'Payment record not found.');
            }

            // التحقق من حالة الدفع من Stripe
            Stripe::setApiKey(config('services.stripe.secret'));
            
            $session = Session::retrieve($payment->stripe_payment_intent_id);

            // dd($session->payment_status);

            if ($session->payment_status === 'paid')
            {
                // dd($payment);
                // تحديث حالة الدفع
                $payment->update([
                    'status' => 'completed',
                    'stripe_charge_id' => $session->payment_intent,
                ]);

                // تحديث حالة الطلب
                $serviceRequest = $payment->serviceRequest;
                $serviceRequest->update([
                    'payment_status' => 'paid',
                    // 'status' => 'completed',
                ]);

                // dd($serviceRequest);
                return redirect()->route('client.service_request.show', $serviceRequest->id)->with('success', 'Payment completed successfully! 🎉');
            }
                // dd("abed22");
            return redirect()->route('client.service_request.show', $payment->service_request_id)->with('error', 'Payment verification failed.');

        }
        catch (Exception $e)
        {
            // dd("abed33");
            // \Log::error('Stripe Success Callback Error: ' . $e->getMessage());
            
            return redirect()->route('client.service_request.index')->with('error', 'Payment verification error, please try again.');
        }
    }

    /**
     * Payment Cancel Callback
     */
    public function cancel($paymentId)
    {
        try
        {
            $payment = Payment::find($paymentId);

            if (!$payment) {
                return redirect()->route('client.service_request.index')->with('error', 'Payment record not found.');
            }

            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'Payment cancelled by user',
            ]);

            return redirect()
                ->route('client.service_request.show', $payment->service_request_id)->with('warning', 'Payment was cancelled.');

        }
        catch (Exception $e)
        {
            // \log::error('Stripe Cancel Callback Error: ' . $e->getMessage());
            return redirect()->route('client.service_request.index')->with('error', 'Error processing cancellation.');
        }
    }

    /**
     * Calculate Total Amount
     */
    private function calculateTotal(ServiceRequest $serviceRequest): float
    {
        $total = (float)($serviceRequest->inspection_fee ?? 0);

        if ($serviceRequest->client_approved && $serviceRequest->repair_cost)
        {
            $total += (float)$serviceRequest->repair_cost;
        }

        return $total;
    }

    /**
     * Check if payment is allowed
     */
    private function canPay(ServiceRequest $serviceRequest): bool
    {
        $user = Auth::user();
        // dd($user);
        
        // التحقق من أن المستخدم هو العميل صاحب الطلب
        if (!$user || !$user->userable)
        {
            return false;
        }
        
        // dd("abed333");
        // $client = $user->userable_id;
        // $client = $user->userable;

        return $serviceRequest->repair_cost > 0
            && $serviceRequest->status === 'approved_for_repair'
            && $serviceRequest->client_approved == 1
            && $user->userable->id == $serviceRequest->client_id;
    }
}