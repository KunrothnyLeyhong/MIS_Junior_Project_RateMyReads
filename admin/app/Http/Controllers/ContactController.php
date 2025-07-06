<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Fetch all messages ordered by latest
        $contacts_us = ContactUs::latest()->get();

        return view('contact.contact_us', compact('contacts_us'));
    }

    public function reply($id)
    {
        // Logic for reply view or action (you can modify as needed)
        $contact_us = ContactUs::findOrFail($id);
        return view('contact.contact_us.reply', compact('contact_us'));
    }

    // Optional: reply POST action
    public function sendReply(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'reply_message' => 'required|string',
        ]);

        $contact_us = ContactUs::findOrFail($id);

        // Example: Send email (replace with your email logic)
        \Mail::raw($request->reply_message, function ($mail) use ($contact_us) {
            $mail->to($contact_us->email)
                 ->subject('Reply to your message');
        });

        return redirect()->route('contact.contact_us.messages')->with('success', 'Reply sent successfully!');
    }
}
