<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

// NOTE: 'register', 'login', 'otp.form', 'otp.verify', 'otp.resend' are
// intentionally NOT defined here anymore — they live in routes/web.php
// using our custom RegisteredUserController / AuthController / OtpController
// (which implement the email-link verify + OTP login flow). Defining them
// here too caused a route-name collision that silently overrode our
// custom OTP flow with Breeze's default session login.

Route::middleware('guest')->group(function () {

    // ===== OTP-based password reset =====
    Route::get('forgot-password', [ForgotPasswordController::class, 'showEmailForm'])
        ->name('password.request');

    Route::post('forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.otp.send');

    Route::get('forgot-password/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])
        ->name('password.otp.form');

    Route::post('forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
        ->name('password.otp.verify');

    Route::post('forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])
        ->name('password.otp.resend');

    Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset.form');

    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.reset.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});