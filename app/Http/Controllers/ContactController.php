<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you can add your email sending logic
        // For example, using Laravel's Mail facade:
        /*
        Mail::to('your-email@example.com')->send(new ContactFormMail($validated));
        */

        return redirect()->back()->with('success', 'Thank you for your message. I will get back to you soon!');
    }
}
