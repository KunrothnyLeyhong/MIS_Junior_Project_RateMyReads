<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminPasswordController extends Controller
{
    // Show password change form
    public function password()
    {
        return view('adminprofile.password');
    }

    // Handle password update
    public function updatePassword(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Get the authenticated admin user
        $admin = Auth::user();

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->with('error', 'Old password does not match.');
        }

        // Update the password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
