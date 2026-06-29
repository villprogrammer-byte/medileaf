<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'reason' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = $request->all();

        Mail::send('emails.contact', compact('data'), function ($mail) use ($data) {
            $mail->to('admin@medileaf.com.au')
                ->replyTo($data['email'], $data['first_name'] . ' ' . $data['last_name'])
                ->subject('New Contact Enquiry - MediLeaf');
        });

        return back()->with('success', 'Your enquiry has been sent successfully.');
    }
}