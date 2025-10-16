<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\RejectedRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Validate status transitions
        if ($order->status == 'assigned' && $request->status == 'completed')
        {
            return redirect()->back()->with('error', 'You must start the job before completing it.');
        }

        if ($order->status == 'completed' || $order->status == 'canceled')
        {
            return redirect()->back()->with('error', 'Cannot update a completed or canceled request.');
        }

        $order->status = $request->status;
        $order->save();

        $statusMessage = [
            'in_progress' => 'Job started successfully!',
            'completed' => 'Job completed successfully!',
            'canceled' => 'Request has been canceled.'
        ];

        return redirect()->route('technician_request.myRequests')->with('success', $statusMessage[$request->status]);
    }
}
