<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreRegisterRequest $request)
    {
        $validated = $request->validated();

        // Verify Cloudflare Turnstile
        $turnstile = Http::asForm()
            ->withOptions([
                'curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4],
            ])
            ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]);

        if (!$turnstile->successful() || !$turnstile->json('success')) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Please complete the security verification and try again.',
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'dob' => $validated['dob'],
            'password' => Hash::make($validated['password']),
        ]);

        // Sends the verification link email automatically (User implements MustVerifyEmail)
        event(new Registered($user));

        Auth::login($user);

        // If the request came from our AJAX form submission, return JSON
        // so the frontend can show the custom "check your email" modal.
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'ok',
                'email' => $user->email,
                'message' => 'Account created. Verification email sent.',
            ]);
        }

        // Fallback for non-JS form submissions.
        return redirect()->route('verification.notice')
            ->with('status', 'Account created! Please check your email to verify your account.');
    }
}