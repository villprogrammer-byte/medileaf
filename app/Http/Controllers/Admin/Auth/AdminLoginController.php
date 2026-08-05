<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\Admin;
use App\Services\AdminOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminLoginController extends Controller
{
    public function __construct(
        protected AdminOtpService $otpService
    ) {
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return back()
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        $otp = $this->otpService->generate($admin);

        Mail::to($admin->email)->send(
            new LoginOtpMail($admin->name, $otp)
        );

        $request->session()->put('admin_otp_admin_id', $admin->id);
        $request->session()->put(
            'admin_remember',
            $request->boolean('remember')
        );

        return redirect()->route('admin.otp.form');
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}