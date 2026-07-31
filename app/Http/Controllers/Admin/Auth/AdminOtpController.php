<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\LoginOtpMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminOtpController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * OTP Page (Admin)
     */
    public function show()
    {
        if (!session()->has('admin_otp_user_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.otp');
    }

    /**
     * Verify OTP (Admin)
     */
    public function verify(VerifyOtpRequest $request)
    {
        $user = User::where('id', session('admin_otp_user_id'))
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if (!$this->otpService->verify($user, $request->otp)) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.',
            ]);
        }

        Auth::login($user, session('admin_remember', false));

        session()->forget([
            'admin_otp_user_id',
            'admin_remember',
        ]);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Resend OTP (Admin)
     */
    public function resend()
    {
        $user = User::where('id', session('admin_otp_user_id'))
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $otp = $this->otpService->generate($user);

        Mail::to($user->email)->send(
            new LoginOtpMail($user->name, $otp)
        );

        return back()->with('success', 'A new OTP has been sent.');
    }
}