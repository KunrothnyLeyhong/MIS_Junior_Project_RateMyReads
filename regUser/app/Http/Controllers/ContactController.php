<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('regUser.contact_us');
    }

    public function store(Request $request)
    {
        // Validate form inputs
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Save to database
        ContactUs::create($validated);

        // Redirect or return success message
        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }

    public function G_store(Request $request)
    {
        // Validate form input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Insert into contact_us table
        ContactUs::insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
