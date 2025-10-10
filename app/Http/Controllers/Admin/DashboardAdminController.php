<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $totalClient = Client::count();
        $activeTechnicians = Technician::where('last_activity', '>=', now()
            ->subMinutes(30))
            ->count();

        $activeTechniciansNow = Technician::where('last_activity', '>=', now()
            ->subMinute())
            ->count();

        $currentMonthClients = Client::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $lastMonthClients = Client::whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->whereYear('created_at', Carbon::now()->subMonth()->year)
                ->count();

            if ($lastMonthClients > 0)
            {
                $growthPercentage = (($currentMonthClients - $lastMonthClients) / $lastMonthClients) * 100;
            }
            else
            {
                $growthPercentage = 100;
            }

        // dd($growthPercentage);
        return view("Admin.dashboard" , compact(
            "user",
            "totalClient",
            "activeTechnicians",
            "activeTechniciansNow",
            "growthPercentage"
        ));
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
