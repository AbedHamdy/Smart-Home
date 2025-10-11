<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTechnicianRequest;
use App\Models\Category;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Technician::with(['user', 'category']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by availability status
        if ($request->filled('availability')) {
            $query->where('availability_status', $request->availability);
        }

        // Filter by minimum rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Apply search if provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            });
        }

        $technicians = $query->paginate();
        $categories = Category::all();

        return view("Admin.Technician.index", compact("technicians", "categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('Admin.Technician.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTechnicianRequest $request)
    {
        $user = Auth::user();
        if(!$user->role == "admin")
        {
            return redirect()->route("login")->with("error" , "You are not authorized to access this page.");
        }
        
        $data = $request->validated();
        // dd($data);
        DB::beginTransaction();
        try {
            if ($request->hasFile('cv_file'))
            {
                $file = $request->file('cv_file');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . rand(1, 100000) . '.' . $extension;
                // dd($filename);
                $destinationPath = public_path('cvs');
                if (!file_exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $data['cv_file'] = 'cvs/' . $filename;
            }

            // Create technician profile
            $technician = Technician::create([
                // 'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'experience_years' => $data['experience_years'],
                'cv_file' => $data['cv_file'] ?? null,
                'availability_status' => 'available',
                'rating' => 0,
            ]);

            if(!$technician)
            {
                throw new \Exception("Failed to create technician application");
            }

            // Create user
            $user = $technician->user()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'role' => 'technician'
            ]);

            if(!$user)
            {
                throw new \Exception("Failed to create technician application");
            }

            DB::commit();
            return redirect()->route('admin.technician')->with('success', 'Technician created successfully.');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create technician. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        if(!$user->role == "admin")
        {
            return redirect()->route("login")->with("error" , "You are not authorized to access this page.");
        }

        $technician = Technician::with(['user', 'category'])->findOrFail($id);
        if(!$technician)
        {
            return redirect()->back()->with("error" , "Technician not found. It may have been deleted or does not exist.");
        }

        return view('Admin.Technician.show', compact('technician'));
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
        $technician = Technician::find($id);
        if(!$technician)
        {
            return redirect()->back()->with("error" , "");
        }

        DB::beginTransaction();
        try
        {
            $technician->user->delete();
            $technician->delete();

            DB::commit();
            return redirect()->route('admin.technician')->with('success', 'Technician deleted successfully.');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with("error" , "Technician deleted failed. Please try again.");
        }
    }
}
