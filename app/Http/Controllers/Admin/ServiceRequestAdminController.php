<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = ServiceRequest::with([
            "client",
            "technician",
            "category",
            "client.user",
            "technician.user",
        ])->paginate();

        return view("Admin.Services.index" , compact("user" , "orders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        // dd($id);
        $order = ServiceRequest::with([
            "client",
            "technician",
            "category",
            "client.user",
            "technician.user",
            "latestPayment",
        ])->find($id);

        if (!$order)
        {
            return redirect()->back()->with('error', 'Service request not found');
        }

        // dd($order->payment_status);
        return view("Admin.Services.notification" , compact("user" , "order"));
    }

    public function updateStatus($id)
    {
        // dd($id);
        $order = ServiceRequest::find($id);
        if(!$order)
        {
            return redirect()->back()->with("error" , "Sorry, the requested service could not be found.");
        }

        $order->update([
            "status" => "rescheduled",
        ]);

        return redirect()->back()->with("success" , "The service request has been successfully rescheduled.");
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
    public function destroy(string $id)
    {
        //
    }
}
