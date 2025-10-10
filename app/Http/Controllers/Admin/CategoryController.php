<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate();
        return view("Admin.Category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Admin.Category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($data);
        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     $category = Category::find($id);
    //     if(!$category)
    //     {
    //         return redirect()->back()->with("error" , "Category not found. It may have been deleted or does not exist.");
    //     }

    //     return view("Admin.Category.show", compact("category"));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->back()->with("error" , "Category not found. It may have been deleted or does not exist.");
        }

        return view("Admin.Category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->back()->with("error" , "Category not found. It may have been deleted or does not exist.");
        }

        $category->update($data);
        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->back()->with("error" , "Category not found. It may have been deleted or does not exist.");
        }

        DB::beginTransaction();
        try
        {
            foreach ($category->technicians as $technician)
            {
                if ($technician->user)
                {
                    $technician->user->delete(); // حذف المستخدم المرتبط بالـ morph
                }
                
                $technician->delete(); // حذف الفني نفسه
            }
            $category->delete();

            DB::commit();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route('category.index')->with('error', 'Category deleted failed!');
        }
    }
}
