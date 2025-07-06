<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
        public function showProfile()
    {
        // Assuming the authenticated admin is retrieved like this
        $admin = auth()->user(); // or however you retrieve the admin

        return view('adminprofile.profile', compact('admin'));
    }
        public function updateProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example for photo validation
            'phone' => 'nullable|string|max:15', // Example for phone validation
            // Add other validation rules as needed
        ]);

        $admin = auth()->user(); // or however you retrieve the admin

        $admin->firstname = $request->input('firstname');
        $admin->lastname = $request->input('lastname');
        $admin->email = $request->input('email');
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public'); // Store the photo
            $admin->photo = $photoPath; // Save the path to the database
        }

        $admin->save();

        return redirect()->route('adminprofile.profile.update')->with('success', 'Profile updated successfully.');
    }
    
}
