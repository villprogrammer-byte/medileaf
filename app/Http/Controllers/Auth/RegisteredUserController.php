<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use App\Services\HalaxyService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected HalaxyService $halaxy
    ) {
    }

    /**
     * Show registration page.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Register a new MediLeaf user.
     */
    public function store(StoreRegisterRequest $request)
    {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Verify Cloudflare Turnstile
        |--------------------------------------------------------------------------
        */

        $turnstile = Http::asForm()
            ->withOptions([
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                ],
            ])
            ->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => config(
                        'services.turnstile.secret_key'
                    ),

                    'response' => $request->input(
                        'cf-turnstile-response'
                    ),

                    'remoteip' => $request->ip(),
                ]
            );

        if (
            !$turnstile->successful()
            || !$turnstile->json('success')
        ) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' =>
                    'Please complete the security verification and try again.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Create MediLeaf User
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'dob' => $validated['dob'],
            'password' => Hash::make(
                $validated['password']
            ),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Try To Link Existing Halaxy Patient
        |--------------------------------------------------------------------------
        |
        | Priority:
        |
        | 1. Email
        | 2. Mobile number fallback
        |
        | IMPORTANT:
        | Halaxy failure must never stop MediLeaf registration.
        |
        */

        try {

            $halaxyPatient = null;

            /*
            |--------------------------------------------------------------------------
            | Match By Email
            |--------------------------------------------------------------------------
            */

            if (!empty($user->email)) {

                $halaxyPatient = $this->halaxy
                    ->findPatientByEmail(
                        $user->email
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Match By Phone If Email Was Not Found
            |--------------------------------------------------------------------------
            */

            if (
                !$halaxyPatient
                && !empty($user->mobile)
            ) {

                $halaxyPatient = $this->halaxy
                    ->findPatientByPhone(
                        $user->mobile
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Save Halaxy Patient ID
            |--------------------------------------------------------------------------
            */

            if (
                $halaxyPatient
                && !empty($halaxyPatient['id'])
            ) {

                $user->halaxy_patient_id =
                    $halaxyPatient['id'];

                $user->save();

                Log::info(
                    'MediLeaf user linked to Halaxy patient.',
                    [
                        'user_id' => $user->id,
                        'halaxy_patient_id' =>
                            $user->halaxy_patient_id,
                    ]
                );
            } else {

                Log::info(
                    'No matching Halaxy patient found during registration.',
                    [
                        'user_id' => $user->id,
                    ]
                );
            }

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Do Not Break Registration
            |--------------------------------------------------------------------------
            */

            Log::warning(
                'Halaxy patient linking failed during MediLeaf registration.',
                [
                    'user_id' => $user->id,
                    'message' => $e->getMessage(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Send Verification Email
        |--------------------------------------------------------------------------
        */

        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | Login User
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        /*
        |--------------------------------------------------------------------------
        | AJAX Response
        |--------------------------------------------------------------------------
        */

        if (
            $request->wantsJson()
            || $request->ajax()
        ) {

            return response()->json([
                'status' => 'ok',
                'email' => $user->email,
                'message' =>
                    'Account created. Verification email sent.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Non-JavaScript Fallback
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('verification.notice')
            ->with(
                'status',
                'Account created! Please check your email to verify your account.'
            );
    }
}