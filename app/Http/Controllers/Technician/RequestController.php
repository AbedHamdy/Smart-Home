<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\RejectedRequest;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\InspectionReportSubmittedToAdmin;
use App\Notifications\InspectionReportSubmittedToClient;
use App\Notifications\IssueReported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
// use App\Models\Notification;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $technician = $user->userable;

        if (!$technician || !$technician->latitude || !$technician->longitude)
        {
            return back()->with('error', 'Unable to determine your location. Please ensure your location is enabled.');
        }

        $radius = 20;

        $serviceRequests = ServiceRequest::select(
            'service_requests.*',
            DB::raw("(
                6371 * acos(
                    cos(radians($technician->latitude)) *
                    cos(radians(service_requests.latitude)) *
                    cos(radians(service_requests.longitude) - radians($technician->longitude)) +
                    sin(radians($technician->latitude)) *
                    sin(radians(service_requests.latitude))
                )
            ) AS distance")
        )
            ->where('status', 'pending')
            ->where('category_id', $technician->category_id)
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->paginate( );

        $rejectedIds = RejectedRequest::where('technician_id', $technician->id)
            ->pluck('service_request_id')
            ->toArray();

        $serviceRequests->setCollection(
            $serviceRequests->getCollection()->reject(function ($request) use ($rejectedIds) {
                return in_array($request->id, $rejectedIds);
            })
        );

        return view("Technician.Request.index", compact("user", "serviceRequests"));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        // dd($id);
        $order = ServiceRequest::with(["category" , "client"])
            ->where("id" , $id)
            ->first();

        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, we couldn’t find this service request.");
        }

        // dd($order->client->user);

        // dd($order);
        return view("Technician.Request.show" , compact("user" , "order"));
    }

    public function accept($id)
    {
        $user = Auth::user();
        $order = ServiceRequest::find($id);
        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, we couldn’t find this service request.");
        }

        if($order->status != "pending")
        {
            return redirect()->back()->with("error" , "This request is not pending.");
        }

        DB::beginTransaction();
        try
        {
            $order->status = 'assigned';
            $order->technician_id = $user->userable_id;
            $order->save();

            DB::commit();
            return redirect()->route('technician_requests.index')->with('success', 'Request accepted successfully!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to accept request. Please try again.');
        }
    }

    public function reject($id)
    {
        $order = ServiceRequest::find($id);
        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, we couldn’t find this service request.");
        }

        if($order->status != "pending")
        {
            return redirect()->back()->with("error" , "This request is not pending.");
        }

        DB::beginTransaction();
        try
        {
            $status = RejectedRequest::create([
                "service_request_id" => $order->id,
                "technician_id" => Auth::user()->userable_id,
            ]);

            if(!$status)
            {
                throw new \Exception("Failed to reject request.");
            }

            DB::commit();
            return redirect()->route('technician_requests.index')->with('success', 'Request rejected.');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to reject request. Please try again.');
        }
    }

    public function myRequests()
    {
        $user = Auth::user();
        // dd($user);
        $query = ServiceRequest::with(['category', 'client.user'])
            ->where("technician_id", $user->userable_id);

        // Filter by status if provided
        if (request('status'))
        {
            $query->where('status', request('status'));
        }

        // Get paginated results
        $serviceRequests = $query->latest()->paginate();
        return view("Technician.Request.my_requests" , compact("user" , "serviceRequests"));
    }

    public function showOne($id)
    {
        $user = Auth::user();
        $order = ServiceRequest::with(["category" , "client"])
            ->where("id" , $id)
            ->first();

        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, we couldn’t find this service request.");
        }

        return view("Technician.Request.showOne" , compact("user" , "order"));
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'status' => 'required|in:in_progress,completed,canceled'
        ]);

        $order = ServiceRequest::where('id', $id)
            ->where('technician_id', $user->userable_id)
            ->first();

        if (!$order)
        {
            return redirect()->back()->with('error', 'Request not found or you do not have permission.');
        }

        // dd($order);
        // التحقق من الانتقالات المسموح بها
        if ($order->status == 'assigned' && $request->status == 'completed')
        {
            return redirect()->back()->with('error', 'You must start the job before completing it.');
        }

        // ✅ السماح بتحويل rescheduled إلى in_progress
        if ($order->status == 'rescheduled' && $request->status != 'in_progress')
        {
            return redirect()->back()->with('error', 'You must start the job first.');
        }

        if (in_array($order->status, ['completed', 'canceled']))
        {
            return redirect()->back()->with('error', 'Cannot update a completed or canceled request.');
        }

        if ($order->status == 'approved_for_repair' && $request->status == 'completed')
        {
            if ($order->payment_status !== 'paid')
            {
                return redirect()->back()->with('error', 'Cannot complete the job before payment is made.');
            }
        }

        // ✅ تحديث حالة الطلب
        $order->status = $request->status;
        $order->save();

        // ✅ تحديث حالة الفني حسب حالة الطلب
        $technician = $user->userable;

        if ($technician)
        {
            if ($request->status === 'in_progress')
            {
                $technician->availability_status = 'busy';
            }
            elseif (in_array($request->status, ['completed', 'canceled']))
            {
                $technician->availability_status = 'available';
            }
            $technician->save();
        }

        // ✅ الرسائل
        $statusMessage = [
            'in_progress' => 'Job started successfully!',
            'completed' => 'Job completed successfully!',
            'canceled' => 'Request has been canceled.'
        ];

        return redirect()->route('technician_request.myRequests')->with('success', $statusMessage[$request->status]);
    }

    public function reportIssue(Request $request, $orderId)
    {
        $data = $request->validate([
            'issue_type' => 'required|string',
            'technician_report' => 'required|string|min:10',
        ]);

        // dd($data);
        $order = ServiceRequest::find($orderId);
        if (!$order)
        {
            return redirect()->back()->with('error', 'Request not found or you do not have permission.');
        }

        if ($order->technician_id != Auth::user()->userable_id)
        {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        DB::beginTransaction();
        try
        {
            $order->update([
                'status' => 'issue_reported',
                'technician_report' => $data["technician_report"],
                'issue_type' => $data["issue_type"],
                'issue_reported_at' => now(),
            ]);

            // dd($order->client->user);
            $order->client->user->notify(new IssueReported($order));

            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin)
            {
                $admin->notify(new IssueReported($order, true));
            }

            DB::commit();
            return redirect()->back()->with('success', 'Issue reported successfully. Admin will review it soon.');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong while submitting the issue. Please try again later.');
        }
    }

    public function submitInspection(Request $request, $id)
    {
        $data = $request->validate([
            'technician_report' => 'required|string|min:20',
            'repair_cost' => 'required|numeric|min:0',
        ]);

        // dd($data);
        $order = ServiceRequest::find($id);
        if (!$order)
        {
            return redirect()->back()->with('error', 'Request not found or you do not have permission.');
        }

        // تأكد أن الطلب للفني الحالي
        if ($order->technician_id != Auth::user()->userable_id)
        {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        // تأكد أن الحالة in_progress
        if ($order->status != 'in_progress')
        {
            return redirect()->back()->with('error', 'Invalid request status');
        }

        // حفظ تقرير المعاينة وسعر التصليح
        DB::beginTransaction();
        try
        {
            $order->update([
                'technician_report' => $data["technician_report"],
                'repair_cost' => $data["repair_cost"],
                "status" => "waiting_for_approval",
                // 'client_approved' => null,
            ]);

            $userOfClient = $order->client->user;
            // dd($userOfClient);

            // إرسال إشعار للعميل
            $userOfClient->notify(new InspectionReportSubmittedToClient($order));

            // إرسال إشعار للأدمن أيضاً
            $adminUsers = User::where('role', 'admin')->get();
            Notification::send($adminUsers, new InspectionReportSubmittedToAdmin($order));

            DB::commit();
            return redirect()->back()->with('success', 'Inspection report submitted successfully. Waiting for client approval.');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while submitting the inspection report. Please try again or contact support.' . $e->getMessage())->withInput();
        }
    }
}
