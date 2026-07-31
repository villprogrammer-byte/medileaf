<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Step 1 of login: verify credentials + Turnstile, then send an OTP
     * and redirect to the OTP verification page.
     */
    public function sendLoginOtp(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Verify Cloudflare Turnstile
        $turnstile = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!$turnstile->successful() || !$turnstile->json('success')) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Please complete the security verification and try again.',
            ]);
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        // Generate + send OTP (same pattern as OtpController::resend)
        $otp = $this->otpService->generate($user);

        Mail::to($user->email)->send(
            new LoginOtpMail($user->name, $otp)
        );

        // Stash what OtpController::verify() expects in the session
        $request->session()->put('otp_user_id', $user->id);
        $request->session()->put('remember', $request->boolean('remember'));

        return redirect()->route('otp.form');
    }
}