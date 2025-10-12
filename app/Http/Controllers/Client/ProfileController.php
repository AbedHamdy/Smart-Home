<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $client = $user->userable;
        // dd($client);
        return view("Client.profile" , compact("user" , "client"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProfileRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        DB::beginTransaction();
        try
        {
            $user->update([
                "name" => $data["name"],
                "phone" => $data["phone"],
            ]);

            $user->userable->update([
                'address' => $data["address"],
            ]);

            DB::commit();
            return redirect()->back()->with("success" , "Your profile has been updated successfully");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with("error" , "An error occurred while updating your profile. Please try again later");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password))
        {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
