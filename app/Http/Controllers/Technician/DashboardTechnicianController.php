<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardTechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $technician = $user->userable;

        $jobs = ServiceRequest::where("technician_id", $user->userable_id)->count();

        $weekAgo = Carbon::now()->subDays(7);
        $recentJobs = ServiceRequest::where("technician_id", $user->userable_id)
            ->where('created_at', '>=', $weekAgo)
            ->count();

        $completed = ServiceRequest::where("technician_id", $user->userable_id)
            ->where("status", "completed")
            ->count();

        $successRate = $jobs > 0 ? round(($completed / $jobs) * 100, 1) : 0;

        $progress = ServiceRequest::where("technician_id", $user->userable_id)
            ->where("status", "in_progress")
            ->count();

        $dueToday = ServiceRequest::where("technician_id", $user->userable_id)
            ->where("status", "in_progress")
            ->whereDate('created_at', Carbon::today())
            ->count();

        $monthAgo = Carbon::now()->subMonth();
        $averageRating = Rating::where("technician_id", $technician->id)
            ->where("created_at", ">=", $monthAgo)
            ->avg("rating");

        $averageRating = round($averageRating ?? 0, 1);

        $assignedJobs = ServiceRequest::where('technician_id', $user->userable_id)
            ->latest()
            ->take(5)
            ->get();

        $recentRating = Rating::where('technician_id', $user->userable_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ==================== بيانات الرسم البياني ====================

        // آخر 7 أيام
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $count = ServiceRequest::where('technician_id', $user->userable_id)
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->count();

            $last7Days->push([
                'date' => $date->format('M d'),
                'count' => $count
            ]);
        }

        // آخر 30 يوم
        $last30Days = collect();
        for ($i = 29; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $count = ServiceRequest::where('technician_id', $user->userable_id)
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->count();

            $last30Days->push([
                'date' => $date->format('M d'),
                'count' => $count
            ]);
        }

        // آخر 6 شهور
        $last6Months = collect();
        for ($i = 5; $i >= 0; $i--)
        {
            $date = Carbon::now()->subMonths($i);
            $count = ServiceRequest::where('technician_id', $user->userable_id)
                ->where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $last6Months->push([
                'date' => $date->format('M Y'),
                'count' => $count
            ]);
        }

        // Default data (آخر 7 أيام)
        $chartLabels = $last7Days->pluck('date');
        $chartData = $last7Days->pluck('count');

        // إذا كان الطلب AJAX (عند تغيير الفترة)
        if ($request->ajax())
        {
            $period = $request->get('period', '7days');

            switch ($period)
            {
                case '30days':
                    return response()->json([
                        'chartLabels' => $last30Days->pluck('date'),
                        'chartData' => $last30Days->pluck('count')
                    ]);
                case '6months':
                    return response()->json([
                        'chartLabels' => $last6Months->pluck('date'),
                        'chartData' => $last6Months->pluck('count')
                    ]);
                default: // 7days
                    return response()->json([
                        'chartLabels' => $last7Days->pluck('date'),
                        'chartData' => $last7Days->pluck('count')
                    ]);
            }
        }

        return view("Technician.dashboard", compact(
            "user",
            "jobs",
            "recentJobs",
            "completed",
            "successRate",
            "progress",
            "dueToday",
            "technician",
            "averageRating",
            "assignedJobs",
            "recentRating",
            "chartLabels",
            "chartData",
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
