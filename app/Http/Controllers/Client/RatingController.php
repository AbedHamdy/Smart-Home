<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Models\Rating;
use App\Models\ServiceRequest;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        // dd($user);
        $order = ServiceRequest::where("id" , $data["service_request_id"])
            ->where("client_id" , $user->userable_id)
            ->first();

        if(!$order)
        {
            return redirect()->back()->with("error" , "This request was not found or does not belong to your account.")->withInput();
        }

        DB::beginTransaction();
        try
        {
            $rate = Rating::updateOrCreate([
                "service_request_id" => $order->id,
            ],[
                "technician_id" => $order->technician_id,
                "client_id" => $user->userable_id,
                "rating" => $data["rating"],
                "comment" => $data["comment"],
            ]);

            if(!$rate)
            {
                return redirect()->back()->with("error" , "Rating failed. Please try again or contact support if the issue persists.")->withInput();
            }

            $technician = Technician::find($order->technician_id);
            $average = Rating::where('technician_id', $technician->id)->avg('rating');
            $technician->update([
                "rating" => $average,
            ]);

            DB::commit();
            return redirect()->back()->with("success" , "Rating submitted successfully.");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with("error" , "Rating failed. Please try again or contact support if the issue persists.")->withInput();
        }
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
