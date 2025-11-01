<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\RegisterTechnicianRequest;
use App\Mail\TechnicianVerificationMail;
use App\Models\Category;
use App\Models\Client;
use App\Models\Technician;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\TechnicianApplicationSubmitted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        // dd(session('error'));
        return view("Auth.login");
    }

    public function CheckLogin(LoginRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]))
        {
            request()->session()->regenerate();
            $user = Auth::user();
            $role = $user->role;
            switch ($role)
            {
                case 'admin':
                    return redirect()->route('admin_dashboard')->with('success', 'Welcome Admin!');
                case 'client':
                    // dd($user);
                    return redirect()->route('client_dashboard')->with('success', 'Welcome Client!');
                case 'technician':
                    $technician = $user->userable;
                    if (!$technician->verified)
                    {
                        // Generate verification code
                        $verificationCode = rand(100000, 999999);

                        // Store code in session
                        session([
                            'verification_code' => $verificationCode,
                            'technician_id' => $technician->id,
                            'verification_attempts' => 0
                        ]);

                        // Send verification email
                        try
                        {
                            Mail::to($user->email)->send(new TechnicianVerificationMail($user->name, $verificationCode));
                            Log::info("Trying to send verification mail to: " . $user->email);
                            // dd($user);

                            return redirect()->route('technician.verification')->with('success', 'A verification code has been sent to your email.');
                        }
                        catch (\Exception $e)
                        {
                            return redirect()->route('technician.verification')->with('info', 'Please enter the verification code.'.$e->getMessage());
                        }
                    }

                    if($user->role == "technician")
                    {
                        // $technician = $user->userable;
                        $technician->update([
                            "status" => "online",
                        ]);
                    }

                    return redirect()->route('technician_dashboard')->with('success', 'Welcome Technician!');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Your role is not recognized.');
            }
        }

        return redirect()->back()->with('error', 'Email or password is incorrect');
    }

    public function registerTechnician()
    {
        $categories = Category::all();
        if($categories->isEmpty())
        {
            return redirect()->back()->with("error" , "Currently there are no categories available. The website is under testing.");
        }

        // dd($categories);
        return view("Auth.register_technician" , compact("categories"));
    }

    public function registrationTechnician(RegisterTechnicianRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        DB::beginTransaction();
        try
        {
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

            $technician = TechnicianApplication::create([
                "name" => $data["name"],
                "email" => $data["email"],
                "phone" => $data["phone"],
                "category_id" => $data["category_id"],
                'experience' => $data['experience_years'],
                'skills' => $data['skills'] ?? null,
                'cv_file' => $data['cv_file'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            if(!$technician)
            {
                throw new \Exception("Failed to create technician application");
            }

            // $admin->notify(new TechnicianApplicationSubmitted($technician));
            $admins = User::where('role', 'admin')->get(); // جلب كل الأدمنز
            foreach($admins as $admin)
            {
                $admin->notify(new TechnicianApplicationSubmitted($technician));
            }

            DB::commit();
            return redirect()->back()->with("success" , "Your application has been submitted successfully! We will review it and get back to you soon.");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with("error" , "Something went wrong while submitting your application. Please try again later." . $e->getMessage())->withInput();
        }
    }

    public function registerClient()
    {
        return view("Auth.register_client");
    }

    public function registrationClient(RegisterRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        DB::beginTransaction();
        try
        {
            $client = Client::create([
                "address" => $data["address"],
            ]);

            if(!$client)
            {
                throw new \Exception("Failed to create client");
            }

            $user = $client->user()->create([
                "name" => $data["name"],
                "email" => $data["email"],
                "phone" => $data["phone"],
                "password" => Hash::make($data["password"]),
            ]);

            if(!$user)
            {
                throw new \Exception("Failed to create client");
            }

            DB::commit();
            return redirect()->route("login")->with("success" , "Your client account has been created successfully!");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with("error" , "Something went wrong while registering your client. Please try again later.")->withInput();
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if($user->role == "technician")
        {
            $technician = $user->userable;
            $technician->update([
                "status" => "Offline",
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
