<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controller;
use App\Models\Order; // لو عندك موديل للأوردرات
use App\Models\ServiceRequest;

class PaymentController extends Controller
{
    // 🔹 استقبال بيانات الدفع من Paymob (Webhook)
    public function processed(Request $request)
    {
        $data = $request->all(); // بيانات الدفع كلها

        // مثال: تحديث حالة الطلب
        $order = ServiceRequest::find($data['order_id'] ?? null); // تأكد إن order_id موجود
        if ($order)
        {
            if (!empty($data['success']) && $data['success'] == true)
            {
                $order->status = 'paid';
            }
            else
            {
                $order->status = 'failed';
            }
            $order->save();
        }

        return response()->json(['status' => 'ok']); // رد على Paymob
    }

    // 🔹 صفحة العميل بعد الدفع
    public function response(Request $request)
    {
        // البيانات اللي هتيجي من Paymob بعد redirect
        $status = $request->status ?? 'unknown';

        return view('Client.Payment.response', compact('status'));
    }
}
