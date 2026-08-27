<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PractitionerReferralController extends Controller
{
    /**
     * Store practitioner referral
     */
    public function store(Request $request)
    {
        $request->validate([
            'practitioner_name' => 'required|string|max:255',
            'practice_name' => 'nullable|string|max:255',
            'practitioner_email' => 'required|email',
            'practitioner_phone' => 'required|string|max:50',

            'patient_first_name' => 'required|string|max:255',
            'patient_last_name' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string|max:50',
            'patient_dob' => 'required|date',

            'medicare_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',

            'consent' => 'required'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cloudflare Turnstile Verification
        |--------------------------------------------------------------------------
        */

        $token = $request->input('cf-turnstile-response');

        if (!$token) {
            return back()
                ->withErrors([
                    'cf-turnstile-response' => 'Please complete the security verification.'
                ])
                ->withInput();
        }


        $verify = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]
        );


        if (!$verify->json('success')) {
            return back()
                ->withErrors([
                    'cf-turnstile-response' => 'Security verification failed.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Save / Email
        |--------------------------------------------------------------------------
        |
        | Abhi database table nahi banayi hai,
        | isliye email notification ke liye ready structure.
        |
        */


        Mail::raw(
            "
            New Practitioner Referral

            Practitioner:
            {$request->practitioner_name}

            Practice:
            {$request->practice_name}

            Email:
            {$request->practitioner_email}

            Phone:
            {$request->practitioner_phone}


            Patient:
            {$request->patient_first_name} {$request->patient_last_name}

            Patient Email:
            {$request->patient_email}

            Patient Phone:
            {$request->patient_phone}

            DOB:
            {$request->patient_dob}

            Medicare:
            {$request->medicare_number}

            Notes:
            {$request->notes}
            ",
            function ($message) {

                $message
                    ->to('admin@medileaf.com.au')
                    ->subject('New Practitioner Referral Received');

            }
        );


        return back()->with(
            'success',
            'Thank you. Your referral has been submitted successfully.'
        );
    }
}