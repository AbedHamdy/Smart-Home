<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Technician;
use Illuminate\Support\Facades\Mail;
use App\Mail\TechnicianVerificationMail;

class TechnicianVerificationController extends Controller
{
    public function show()
    {
        // Check if there's a verification code in session
        if (!session()->has('verification_code'))
        {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        return view('Technician.verify-email');
    }

    // Verify the code
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6'
        ]);

        // Get stored code from session
        $storedCode = session('verification_code');
        $technicianId = session('technician_id');
        $attempts = session('verification_attempts', 0);

        // Check if code matches
        if ($request->code == $storedCode) {
            // Update technician verification status
            $technician = Technician::find($technicianId);
            $technician->verified = true;
            $technician->save();

            // Clear session
            session()->forget(['verification_code', 'technician_id', 'verification_attempts']);

            // Login the user
            $user = $technician->user;
            auth()->login($user);

            return redirect()->route('technician_dashboard')
                ->with('success', 'Your account has been verified successfully!');
        } else {
            // Increment attempts
            $attempts++;
            session(['verification_attempts' => $attempts]);

            // Check if max attempts reached
            if ($attempts >= 3) {
                session()->forget(['verification_code', 'technician_id', 'verification_attempts']);

                return redirect()->route('login')
                    ->with('error', 'Too many failed attempts. Please login again.');
            }

            return back()->with('error', 'Invalid verification code. Attempts remaining: ' . (3 - $attempts));
        }
    }

    // Resend verification code
    public function resend(Request $request)
    {
        $technicianId = session('technician_id');

        if (!$technicianId)
        {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        // Generate new code
        $verificationCode = rand(100000, 999999);

        // Update session
        session([
            'verification_code' => $verificationCode,
            'verification_attempts' => 0
        ]);

        // Get technician and send email
        $technician = Technician::find($technicianId);
        $user = $technician->user;

        try
        {
            Mail::to($user->email)->send(new TechnicianVerificationMail($user->name, $verificationCode));

            return back()->with('success', 'A new verification code has been sent to your email.');
        }
        catch (\Exception $e)
        {
            return back()->with('error', 'Failed to send email. Please try again.' . $e->getMessage());
        }
    }
}
