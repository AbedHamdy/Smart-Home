<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TechnicianStatusMail;
use App\Models\Technician;
use App\Models\TechnicianApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TechnicianRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technicianRequests = TechnicianApplication::with("category")->paginate();

        return view("Admin.TechnicianRequests.index" , compact("technicianRequests"));
    }

    public function approve($id)
    {
        $technician = TechnicianApplication::find($id);
        if(!$technician)
        {
            return redirect()->back()->with("error" , "Technician not found, It may have been deleted or does not exist.");
        }

        // dd($technician);
        DB::beginTransaction();
        try
        {
            $newTechnician = Technician::create([
                "category_id" => $technician->category_id,
                "experience_years" => $technician->experience,
                "cv_file" => $technician->cv_file ?? null,
                'availability_status' => 'available',
                'rating' => 0,
            ]);

            if(!$technician)
            {
                throw new \Exception("Failed to create technician application");
            }

            // Create user
            $user = $newTechnician->user()->create([
                'name' => $technician->name,
                'email' => $technician->email,
                'phone' => $technician->phone,
                'password' => Hash::make("password123"),
                'role' => 'technician'
            ]);

            if(!$user)
            {
                throw new \Exception("Failed to create technician application");
            }

            Mail::to($technician->email)->send(new TechnicianStatusMail($technician->name, 'approved', 'password123'));
            $technician->delete();

            DB::commit();
            return redirect()->route("admin_technician_requests.index")->with('success', 'Technician created successfully.');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with("error" , "Failed to create technician. Please try again.");
        }
    }

    public function reject($id)
    {
        $technician = TechnicianApplication::find($id);
        if(!$technician)
        {
            return redirect()->back()->with("error" , "Technician not found, It may have been deleted or does not exist.");
        }

        DB::beginTransaction();
        try
        {
            Mail::to($technician->email)->send(new TechnicianStatusMail($technician->name, 'rejected'));

            $technician->update([
                "status" => "rejected",
            ]);

            DB::commit();
            return redirect()->route("admin_technician_requests.index")->with("success" , "Technician rejected successfully.");
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with("error" , "Failed to create technician. Please try again.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $technicianRequest = TechnicianApplication::find($id);
        if(!$technicianRequest)
        {
            return redirect()->back()->with("error" , "Technician not found, It may have been deleted or does not exist.");
        }

        // dd($technician);
        return view("Admin.TechnicianRequests.show" , compact("technicianRequest"));
    }
}
