<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AdminForgotPasswordController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showEmailForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $admin = User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => 'We could not find an admin account with that email address.',
            ]);
        }

        $otp = $this->otpService->generate($admin);

        Mail::to($admin->email)->send(new ResetPasswordOtpMail($admin->name, $otp));

        $request->session()->put('admin_reset_user_id', $admin->id);
        $request->session()->forget('admin_reset_verified');

        return redirect()->route('admin.password.otp.form');
    }

    public function showOtpForm()
    {
        if (!session()->has('admin_reset_user_id')) {
            return redirect()->route('admin.password.request');
        }

        return view('admin.auth.forgot-password-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'digits:6']]);

        $admin = User::where('id', session('admin_reset_user_id'))
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return redirect()->route('admin.password.request');
        }

        if (!$this->otpService->verify($admin, $request->otp)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $request->session()->put('admin_reset_verified', true);

        return redirect()->route('admin.password.reset.form');
    }

    public function showResetForm()
    {
        if (!session()->has('admin_reset_user_id') || !session('admin_reset_verified')) {
            return redirect()->route('admin.password.request');
        }

        return view('admin.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session()->has('admin_reset_user_id') || !session('admin_reset_verified')) {
            return redirect()->route('admin.password.request');
        }

        $request->validate(['password' => ['required', 'string', 'min:8', 'confirmed']]);

        $admin = User::where('id', session('admin_reset_user_id'))
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return redirect()->route('admin.password.request');
        }

        $admin->update(['password' => Hash::make($request->password)]);

        $request->session()->forget(['admin_reset_user_id', 'admin_reset_verified']);

        return redirect()->route('admin.login')
            ->with('status', 'Your password has been reset. Please log in with your new password.');
    }

    public function resendOtp(Request $request)
    {
        $admin = User::where('id', session('admin_reset_user_id'))
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return redirect()->route('admin.password.request');
        }

        $otp = $this->otpService->generate($admin);

        Mail::to($admin->email)->send(new ResetPasswordOtpMail($admin->name, $otp));

        return back()->with('success', 'A new OTP has been sent.');
    }
}