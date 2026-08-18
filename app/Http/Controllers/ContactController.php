<?php

namespace App\Http\Controllers;

use App\Rules\Turnstile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Honeypot: hidden field only bots fill in. Silently drop, no error shown.
        if ($request->filled('website')) {
            return back()->with('success', 'Your enquiry has been sent successfully.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'reason' => 'required|string',
            'message' => 'required|string',
            'cf-turnstile-response' => ['required', new Turnstile],
        ]);

        $data = $request->all();

        try {
            Mail::send('emails.contact', compact('data'), function ($mail) use ($data) {

                $mail->from(
                    config('mail.from.address'), // must match authenticated mailbox in .env
                    'MediLeaf Website'
                );

                $mail->to('medileaf.pottspoint@gmail.com', 'MediLeaf Contact Form');

                $mail->replyTo(
                    $data['email'],
                    $data['first_name'] . ' ' . $data['last_name']
                );

                $mail->subject('New Contact Enquiry');
            });
        } catch (\Exception $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }

        return back()->with('success', 'Your enquiry has been sent successfully.');
    }
}