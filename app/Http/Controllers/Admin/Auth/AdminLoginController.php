<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show Admin Login Page
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle Admin Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}