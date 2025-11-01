<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Payment;
use App\Models\ServiceRequest;
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
        $activeTechnicians = Technician::where('last_activity', '>=', now()->subMinutes(30))->count();
        $activeTechniciansNow = Technician::where('last_activity', '>=', now()->subMinute())->count();

        $currentMonthClients = Client::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $lastMonthClients = Client::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($lastMonthClients > 0) {
            $growthPercentage = (($currentMonthClients - $lastMonthClients) / $lastMonthClients) * 100;
        } else {
            $growthPercentage = 100;
        }

        $techniciansTopRating = Technician::with(['user', 'category'])
            ->where('rating', '>=', 4.8)
            ->take(3)
            ->get();

        $recentRequests = ServiceRequest::with(['client.user', 'technician.user', 'category'])
            ->latest()
            ->take(4)
            ->get();

        $RequestsCount = ServiceRequest::count();
        $RequestsPendingCount = ServiceRequest::where("status", "pending")->count();
        $categories = Category::with("serviceRequests")->take(4)->get();

        $total = Payment::where('status', 'completed')->sum('amount');
        $currentMonthRevenue = Payment::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $lastMonthRevenue = Payment::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');

        if ($lastMonthRevenue > 0)
        {
            $revenueGrowthPercentage = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }
        else
        {
            $revenueGrowthPercentage = $currentMonthRevenue > 0 ? 100 : 0;
        }

        // بيانات الرسم البياني - آخر 7 أيام
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $revenue = Payment::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('amount');

            $last7Days->push([
                'date' => $date->format('M d'),
                'revenue' => $revenue
            ]);
        }

        // بيانات الرسم البياني - آخر 30 يوم
        $last30Days = collect();
        for ($i = 29; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $revenue = Payment::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('amount');

            $last30Days->push([
                'date' => $date->format('M d'),
                'revenue' => $revenue
            ]);
        }

        // بيانات الرسم البياني - آخر 6 شهور
        $last6Months = collect();
        for ($i = 5; $i >= 0; $i--)
        {
            $date = Carbon::now()->subMonths($i);
            $revenue = Payment::where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount');

            $last6Months->push([
                'date' => $date->format('M Y'),
                'revenue' => $revenue
            ]);
        }

        return view("Admin.dashboard", compact(
            "user",
            "totalClient",
            "activeTechnicians",
            "activeTechniciansNow",
            "growthPercentage",
            "techniciansTopRating",
            "recentRequests",
            "RequestsCount",
            "RequestsPendingCount",
            "categories",
            "total",
            "revenueGrowthPercentage",
            "last7Days",
            "last30Days",
            "last6Months"
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
