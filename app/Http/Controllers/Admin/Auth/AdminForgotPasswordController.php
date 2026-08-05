<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\Admin;
use App\Services\AdminOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AdminForgotPasswordController extends Controller
{
    public function __construct(
        protected AdminOtpService $otpService
    ) {
    }

    /**
     * Show admin forgot-password email form.
     */
    public function showEmailForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Verify admin email and send reset OTP.
     */
    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $admin = Admin::query()
            ->where('email', strtolower(trim($validated['email'])))
            ->first();

        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => 'We could not find an admin account with that email address.',
            ]);
        }

        $otp = $this->otpService->generate($admin);

        Mail::to($admin->email)->send(
            new ResetPasswordOtpMail(
                $admin->name,
                $otp
            )
        );

        $request->session()->put(
            'admin_reset_admin_id',
            $admin->id
        );

        $request->session()->forget([
            'admin_reset_verified',
        ]);

        return redirect()
            ->route('admin.password.otp.form')
            ->with(
                'status',
                'A password reset OTP has been sent to your admin email address.'
            );
    }

    /**
     * Show reset OTP verification page.
     */
    public function showOtpForm()
    {
        if (!session()->has('admin_reset_admin_id')) {
            return redirect()
                ->route('admin.password.request');
        }

        return view('admin.auth.forgot-password-otp');
    }

    /**
     * Verify password reset OTP.
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $admin = Admin::find(
            session('admin_reset_admin_id')
        );

        if (!$admin) {
            $request->session()->forget([
                'admin_reset_admin_id',
                'admin_reset_verified',
            ]);

            return redirect()
                ->route('admin.password.request')
                ->withErrors([
                    'email' => 'The admin account could not be found.',
                ]);
        }

        if (!$this->otpService->verify($admin, $validated['otp'])) {
            return back()
                ->withErrors([
                    'otp' => 'Invalid or expired OTP.',
                ]);
        }

        $request->session()->put(
            'admin_reset_verified',
            true
        );

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.password.reset.form');
    }

    /**
     * Show new-password form.
     */
    public function showResetForm()
    {
        if (
            !session()->has('admin_reset_admin_id') ||
            !session('admin_reset_verified')
        ) {
            return redirect()
                ->route('admin.password.request');
        }

        return view('admin.auth.reset-password');
    }

    /**
     * Save the new admin password.
     */
    public function resetPassword(Request $request)
    {
        if (
            !session()->has('admin_reset_admin_id') ||
            !session('admin_reset_verified')
        ) {
            return redirect()
                ->route('admin.password.request');
        }

        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $admin = Admin::find(
            session('admin_reset_admin_id')
        );

        if (!$admin) {
            $request->session()->forget([
                'admin_reset_admin_id',
                'admin_reset_verified',
            ]);

            return redirect()
                ->route('admin.password.request');
        }

        $admin->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        $request->session()->forget([
            'admin_reset_admin_id',
            'admin_reset_verified',
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('admin.login')
            ->with(
                'status',
                'Your password has been reset successfully. Please log in with your new password.'
            );
    }

    /**
     * Resend password reset OTP.
     */
    public function resendOtp(Request $request)
    {
        $admin = Admin::find(
            session('admin_reset_admin_id')
        );

        if (!$admin) {
            $request->session()->forget([
                'admin_reset_admin_id',
                'admin_reset_verified',
            ]);

            return redirect()
                ->route('admin.password.request');
        }

        $otp = $this->otpService->generate($admin);

        Mail::to($admin->email)->send(
            new ResetPasswordOtpMail(
                $admin->name,
                $otp
            )
        );

        return back()->with(
            'success',
            'A new OTP has been sent to your admin email address.'
        );
    }
}