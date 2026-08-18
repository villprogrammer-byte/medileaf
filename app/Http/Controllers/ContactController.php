<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    public function send(Request $request)
    {
        if ($request->filled('website')) {
            return back()->with(
                'success',
                'Your enquiry has been sent successfully.'
            );
        }


        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',

            'phone' => [
                'required',
                'regex:/^04\d{2}\s?\d{3}\s?\d{3}$/'
            ],

            'email' => 'required|email',
            'reason' => 'required|string',
            'message' => 'required|string|min:20|max:2000',
            'cf-turnstile-response' => 'required',
        ]);


        $verify = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );


        Log::info(
            'Turnstile response: ' . $verify->body()
        );


        if (!$verify->json('success', false)) {

            return back()
                ->withInput()
                ->withErrors([
                    'cf-turnstile-response' => 'Captcha verification failed. Please try again.'
                ]);
        }


        $data = $request->all();


        $data['phone'] = '+61 ' . str_replace(
            ' ',
            '',
            $data['phone']
        );


        try {

            Mail::send(
                'emails.contact',
                compact('data'),
                function ($mail) use ($data) {

                    $mail->from(
                        'admin@medileaf.com.au',
                        'MediLeaf Health'
                    );


                    $mail->to(
                        'info@seobooklab.com'
                    );


                    $mail->replyTo(
                        $data['email'],
                        $data['first_name'] . ' ' . $data['last_name']
                    );


                    $mail->subject(
                        'New Contact Enquiry'
                    );

                }
            );


            Log::info(
                'Contact mail sent successfully'
            );


        } catch (\Exception $e) {

            Log::error(
                'Contact form mail failed: ' . $e->getMessage()
            );


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Something went wrong. Please try again.'
                );
        }


        return back()->with(
            'success',
            'Your enquiry has been sent successfully.'
        );
    }
}