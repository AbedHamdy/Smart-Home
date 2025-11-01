<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Models\Category;
use App\Models\Rating;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = ServiceRequest::where("client_id", $user->userable_id);
        if ($request->has('status') && $request->status != '')
        {
            $query->where('status', $request->status);
        }

        // dd($user->userable_id);
        // $serviceRequests = ServiceRequest::where("client_id" , $user->userable_id)->paginate();
        $serviceRequests = $query->latest()->paginate();
        return view("Client.ServiceRequest.index" , compact("user" , "serviceRequests"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        // dd($user);
        $categories = Category::all();
        return view("Client.ServiceRequest.create", compact("categories" , "user"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        // dd($data);
        $category = Category::where("id" , $data["category_id"])->first();

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . rand(1, 100000) . '.' . $extension;

            $destinationPath = public_path('images/service_requests');
            if (!file_exists($destinationPath))
            {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['image'] = 'images/service_requests/' . $filename;
        }
        else
        {
            $data['image'] = null;
        }

        $order = ServiceRequest::create([
            "client_id" => $user->userable_id,
            "category_id" => $data["category_id"],
            "title" => $data["title"],
            "description" => $data["description"],
            "address" => $data["address"],
            "status" => "pending",
            "latitude" => $data["latitude"],
            "longitude" => $data["longitude"],
            "image" => $data["image"],
            "inspection_fee" => $category->price,
        ]);

        if(!$order)
        {
            return redirect()->back()->with("error" , "Failed to create service request. Please try again.");
        }

        // dd($order);
        return redirect()->back()->with("success" , "Service request created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $order = ServiceRequest::with(["category" , "technician.user"])
            ->where("client_id", $user->userable_id)
            ->where("id" , $id)
            ->first();

        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, this request was not found or you are not authorized to access it.");
        }

        $technician = $order->technician;
        // $completedOrders = $technician->completedRequests()->count();
        $completedOrders = $technician ? $technician->completedRequests()->count() : 0;
        // dd($technician->completedRequests);

        return view("Client.ServiceRequest.show" , compact("user" , "order" , "technician" , "completedOrders"));
    }

    public function respond(Request $request, $id)
    {
        $data = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $user = Auth::user();

        $order = ServiceRequest::where("status" , "waiting_for_approval")
            ->where("client_id", $user->userable_id)
            ->where("id" , $id)
            ->first();

        if (!$order)
        {
            return redirect()->back()->with('error', 'Sorry, this request was not found or you are not authorized to access it.');
        }

        if ($request->action === 'approve')
        {
            $order->update([
                "client_approved" => true,
                "status" => "approved_for_repair",
            ]);

            return redirect()->back()->with("success" , "You have approved the repair request successfully. The technician will proceed with the repair process.");
        }
        elseif ($request->action === 'reject')
        {
            $order->update([
                "client_approved" => false,
                "status" => "canceled",
            ]);

            return redirect()->back()->with("error" , "You have rejected the repair quote. This service request has been canceled.");
        }

        return redirect()->back()->with("error" , "Invalid action. Please try again.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $order = ServiceRequest::with("category")
            ->where("status" , "pending")
            ->where("client_id", $user->userable_id)
            ->where("id" , $id)
            ->first();

        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, this request was not found or you are not authorized to access it.");
        }

        $order->delete();
        return redirect()->route("client.service_request.index")->with("success" , "Service request deleted successfully.");
    }
}
