<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterTechnicianRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }

    public function CheckLogin(RegisterTechnicianRequest $request)
    {
        $data = $request->validated();
        dd($data);
    }

    public function register()
    {
        $categories = Category::all();
        // if($categories->isEmpty())
        // {
        //     return redirect()->back()->with("error" , "Currently there are no categories available. The website is under testing.");
        // }

        // dd($categories);
        return view("register" , compact("categories"));
    }

    public function registration(Request $request)
    {
        $data = $request->validated();
        dd($data);
    }
}
