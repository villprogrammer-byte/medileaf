<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Step 1: Show the "enter your email" form.
     */
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Step 2: Validate the email, send an OTP, redirect to OTP entry page.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'We could not find an account with that email address.',
            ]);
        }

        $otp = $this->otpService->generate($user);

        Mail::to($user->email)->send(
            new ResetPasswordOtpMail($user->name, $otp)
        );

        $request->session()->put('reset_user_id', $user->id);
        $request->session()->forget('reset_verified');

        return redirect()->route('password.otp.form');
    }

    /**
     * Step 3: Show the OTP entry form.
     */
    public function showOtpForm()
    {
        if (!session()->has('reset_user_id')) {
            return redirect()->route('password.request');
        }

        return view('auth.forgot-password-otp');
    }

    /**
     * Step 4: Verify the OTP. If correct, allow access to the reset-password form.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('password.request');
        }

        if (!$this->otpService->verify($user, $request->otp)) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.',
            ]);
        }

        $request->session()->put('reset_verified', true);

        return redirect()->route('password.reset.form');
    }

    /**
     * Step 5: Show the "set new password" form (only if OTP was verified).
     */
    public function showResetForm()
    {
        if (!session()->has('reset_user_id') || !session('reset_verified')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }

    /**
     * Step 6: Update the password.
     */
    public function resetPassword(Request $request)
    {
        if (!session()->has('reset_user_id') || !session('reset_verified')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('password.request');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $request->session()->forget(['reset_user_id', 'reset_verified']);

        return redirect()->route('login')
            ->with('status', 'Your password has been reset. Please log in with your new password.');
    }

    /**
     * Resend OTP for password reset.
     */
    public function resendOtp(Request $request)
    {
        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('password.request');
        }

        $otp = $this->otpService->generate($user);

        Mail::to($user->email)->send(
            new ResetPasswordOtpMail($user->name, $otp)
        );

        return back()->with('success', 'A new OTP has been sent.');
    }
}