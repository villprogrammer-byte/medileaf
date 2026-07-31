<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminLoginController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show Admin Login Page
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Step 1: verify admin credentials, then send OTP
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('role', 'admin')
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        // Generate + send OTP (same service/mailable as patient login)
        $otp = $this->otpService->generate($user);

        Mail::to($user->email)->send(
            new LoginOtpMail($user->name, $otp)
        );

        // Separate session keys from patient login flow to avoid clashing
        $request->session()->put('admin_otp_user_id', $user->id);
        $request->session()->put('admin_remember', $request->boolean('remember'));

        return redirect()->route('admin.otp.form');
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}