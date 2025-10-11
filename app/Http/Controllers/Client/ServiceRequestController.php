<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Models\Category;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
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
