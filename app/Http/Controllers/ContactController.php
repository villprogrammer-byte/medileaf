<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        if ($request->filled('website')) {
            abort(403);
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',

            'phone' => [
                'required',
                'regex:/^4\d{2}\s?\d{3}\s?\d{3}$/'
            ],

            'email' => 'required|email',
            'reason' => 'required|string',
            'message' => 'required|string|min:20|max:2000',
        ]);


        $data = $request->all();


        $data['phone'] = '+61 ' . str_replace(
            ' ',
            '',
            $data['phone']
        );


        Mail::send('emails.contact', compact('data'), function ($mail) use ($data) {

            $mail->from(
                'admin@medileaf.com.au',
                $data['first_name'] . ' ' . $data['last_name']
            );


            $mail->to(
                'admin@medileaf.com.au'
            );


            $mail->replyTo(
                $data['email'],
                $data['first_name'] . ' ' . $data['last_name']
            );


            $mail->subject(
                'New Contact Enquiry'
            );
        });


        return back()->with(
            'success',
            'Your enquiry has been sent successfully.'
        );
    }
}