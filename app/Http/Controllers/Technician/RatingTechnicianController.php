<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingTechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $technician = $user->userable;

        // البدء بـ Query Builder
        $query = Rating::with(["client.user", "serviceRequest"])
            ->where("technician_id", $user->userable_id);

        // تطبيق الفلترة حسب عدد النجوم
        if ($request->has('filter') && $request->filter !== 'all')
        {
            $filter = $request->filter;

            if ($filter === 'low')
            {
                // التقييمات المنخفضة (1 أو 2 نجمة)
                $query->where('rating', '<=', 2);
            }
            elseif (in_array($filter, ['1', '2', '3', '4', '5']))
            {
                // تقييم محدد
                $query->where('rating', $filter);
            }
        }

        // ترتيب حسب الأحدث
        $query->orderBy('created_at', 'desc');

        // عمل Pagination
        $rating = $query->paginate(15);
        // dd($rating);
        // الإحصائيات
        $totalReview = Rating::where("technician_id", $user->userable_id)->count();

        $positiveReviews = Rating::where('technician_id', $user->userable_id)
            ->where('rating', '>=', 4)
            ->count();

        return view("Technician.Rating.index", compact(
            "user",
            "rating",
            "technician",
            "totalReview",
            "positiveReviews"
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
