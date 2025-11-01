<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $client = $user->userable;

        // إحصائيات الطلبات
        $totalRequests = ServiceRequest::where('client_id', $client->id)->count();
        $completedRequests = ServiceRequest::where('client_id', $client->id)
            ->where('status', 'completed')
            ->count();

        $pendingRequests = ServiceRequest::where('client_id', $client->id)
            ->where('status', 'pending')
            ->count();

            $inProgressRequests = ServiceRequest::where('client_id', $client->id)
            ->where('status', 'in_progress')
            ->count();

        // حساب نسبة النجاح
        $successRate = $totalRequests > 0 ? round(($completedRequests / $totalRequests) * 100, 1) : 0;

        // إجمالي المدفوعات
        $totalSpent = Payment::whereHas('serviceRequest', function($query) use ($client) {
            $query->where('client_id', $client->id);
        })->where('status', 'completed')->sum('amount');

        // المدفوعات هذا الشهر
        $currentMonthSpent = Payment::whereHas('serviceRequest', function($query) use ($client) {
            $query->where('client_id', $client->id);
        })
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        // المدفوعات الشهر الماضي
        $lastMonthSpent = Payment::whereHas('serviceRequest', function($query) use ($client) {
            $query->where('client_id', $client->id);
        })
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');

        // حساب نسبة التغيير في المصروفات
        if ($lastMonthSpent > 0)
        {
            $spendingChange = (($currentMonthSpent - $lastMonthSpent) / $lastMonthSpent) * 100;
        }
        else
        {
            $spendingChange = $currentMonthSpent > 0 ? 100 : 0;
        }

        // أحدث الطلبات (آخر 5)
        $recentRequests = ServiceRequest::where('client_id', $client->id)
            ->with(['technician.user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // أكثر الفئات استخداماً
        $topCategories = ServiceRequest::where('client_id', $client->id)
            ->select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->orderBy('total', 'desc')
            ->take(4)
            ->get();

        // ==================== بيانات الرسم البياني ====================

        // آخر 7 أيام - عدد الطلبات
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $count = ServiceRequest::where('client_id', $client->id)
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
            $count = ServiceRequest::where('client_id', $client->id)
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
            $count = ServiceRequest::where('client_id', $client->id)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $last6Months->push([
                'date' => $date->format('M Y'),
                'count' => $count
            ]);
        }

        // آخر 7 أيام - المصروفات للرسم البياني الثاني
        $last7DaysSpending = collect();
        for ($i = 6; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $amount = Payment::whereHas('serviceRequest', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('status', 'completed')
            ->whereDate('created_at', $date)
            ->sum('amount');

            $last7DaysSpending->push([
                'date' => $date->format('M d'),
                'amount' => $amount
            ]);
        }

        // آخر 30 يوم - المصروفات
        $last30DaysSpending = collect();
        for ($i = 29; $i >= 0; $i--)
        {
            $date = Carbon::now()->subDays($i);
            $amount = Payment::whereHas('serviceRequest', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('status', 'completed')
            ->whereDate('created_at', $date)
            ->sum('amount');

            $last30DaysSpending->push([
                'date' => $date->format('M d'),
                'amount' => $amount
            ]);
        }

        // آخر 6 شهور - المصروفات
        $last6MonthsSpending = collect();
        for ($i = 5; $i >= 0; $i--)
        {
            $date = Carbon::now()->subMonths($i);
            $amount = Payment::whereHas('serviceRequest', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('status', 'completed')
            ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('amount');

            $last6MonthsSpending->push([
                'date' => $date->format('M Y'),
                'amount' => $amount
            ]);
        }

        return view("Client.dashboard", compact(
            "user",
            "totalRequests",
            "completedRequests",
            "pendingRequests",
            "inProgressRequests",
            "successRate",
            "totalSpent",
            "currentMonthSpent",
            "spendingChange",
            "recentRequests",
            "topCategories",
            "last7Days",
            "last30Days",
            "last6Months",
            "last7DaysSpending",
            "last30DaysSpending",
            "last6MonthsSpending"
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
