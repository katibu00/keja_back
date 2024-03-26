<?php

namespace App\Http\Controllers;

use App\Models\ContactUsMessage;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function showForm()
    {
        return view('pages.contact_us');
    }


    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Create a new contact us message
        ContactUsMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Optionally, you can add logic here to send notifications or emails to the admin

        return redirect()->back()->with('success', 'Your message has been submitted successfully. We will get back to you soon.');
    }
}
