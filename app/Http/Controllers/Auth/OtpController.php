<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\LoginOtpMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * OTP Page
     */
    public function show()
    {
        if (!session()->has('otp_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.otp');
    }

    /**
     * Verify OTP
     */
    public function verify(VerifyOtpRequest $request)
    {
        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$this->otpService->verify($user, $request->otp)) {

            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.',
            ]);

        }

        Auth::login(
            $user,
            session('remember', false)
        );

        session()->forget([
            'otp_user_id',
            'remember',
        ]);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    /**
     * Resend OTP
     */
    public function resend()
    {
        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        $otp = $this->otpService->generate($user);

        Mail::to($user->email)->send(

            new LoginOtpMail(
                $user->name,
                $otp
            )

        );

        return back()->with(
            'success',
            'A new OTP has been sent.'
        );
    }
}