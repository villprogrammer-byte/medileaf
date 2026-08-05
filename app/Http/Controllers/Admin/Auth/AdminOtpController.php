<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\LoginOtpMail;
use App\Models\Admin;
use App\Services\AdminOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminOtpController extends Controller
{
    public function __construct(
        protected AdminOtpService $otpService
    ) {
    }

    public function show()
    {
        if (!session()->has('admin_otp_admin_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.otp');
    }

    public function verify(VerifyOtpRequest $request)
    {
        $admin = Admin::find(
            session('admin_otp_admin_id')
        );

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        if (!$this->otpService->verify($admin, $request->otp)) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.',
            ]);
        }

        Auth::guard('admin')->login(
            $admin,
            session('admin_remember', false)
        );

        session()->forget([
            'admin_otp_admin_id',
            'admin_remember',
        ]);

        $request->session()->regenerate();

        return redirect()->intended(
            route('admin.dashboard')
        );
    }

    public function resend()
    {
        $admin = Admin::find(
            session('admin_otp_admin_id')
        );

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $otp = $this->otpService->generate($admin);

        Mail::to($admin->email)->send(
            new LoginOtpMail($admin->name, $otp)
        );

        return back()->with(
            'success',
            'A new OTP has been sent.'
        );
    }
}