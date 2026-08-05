<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Prescription\PrescriptionController;
use App\Http\Controllers\Prescription\UploadPrescriptionController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminOtpController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\User\UserDashboardController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/clinic', 'pages.clinic')->name('clinic');
Route::view('/pharmacy', 'pages.pharmacy')->name('pharmacy');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/terms', 'pages.terms')->name('terms');

// Shop
Route::get('/store', [StoreController::class, 'index'])
    ->name('store');

// Dynamic Product Detail Page
Route::get('/product/{product}', [StoreController::class, 'show'])
    ->name('product-view');

Route::view('/cart', 'shop.cart')
    ->name('cart');

Route::view('/checkout', 'shop.checkout')
    ->name('checkout');

// Contact Form
Route::post('/contact-send', [ContactController::class, 'send'])
    ->name('contact.send');

// Prescription Enquiry
Route::get('/prescription', [PrescriptionController::class, 'index'])
    ->name('prescription');

Route::post('/prescription', [PrescriptionController::class, 'store'])
    ->name('prescription.store');

// Upload Prescription
Route::get('/upload-prescription', [UploadPrescriptionController::class, 'index'])
    ->name('upload.prescription');

Route::post('/upload-prescription', [UploadPrescriptionController::class, 'store'])
    ->name('upload.prescription.store');

// =====================================
// Patient Registration
// =====================================

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register.store');
});

// =====================================
// Admin Authentication
// Separate "admin" guard
// =====================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware('guest:admin')
    ->group(function () {

        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [AdminLoginController::class, 'login'])
            ->name('login.submit');

        Route::get('/login/verify-otp', [AdminOtpController::class, 'show'])
            ->name('otp.form');

        Route::post('/login/verify-otp', [AdminOtpController::class, 'verify'])
            ->name('otp.verify');

        Route::post('/login/resend-otp', [AdminOtpController::class, 'resend'])
            ->name('otp.resend');
    });

// =====================================
// Social Login (Google)
// =====================================

Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
        ->name('social.redirect');

    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
        ->name('social.callback');
});


// Admin Forgot Password (OTP-based reset)
Route::middleware('guest')->group(function () {
    Route::get('/admin/forgot-password', [AdminForgotPasswordController::class, 'showEmailForm'])
        ->name('admin.password.request');

    Route::post('/admin/forgot-password/send-otp', [AdminForgotPasswordController::class, 'sendOtp'])
        ->name('admin.password.otp.send');

    Route::get('/admin/forgot-password/verify-otp', [AdminForgotPasswordController::class, 'showOtpForm'])
        ->name('admin.password.otp.form');

    Route::post('/admin/forgot-password/verify-otp', [AdminForgotPasswordController::class, 'verifyOtp'])
        ->name('admin.password.otp.verify');

    Route::post('/admin/forgot-password/resend-otp', [AdminForgotPasswordController::class, 'resendOtp'])
        ->name('admin.password.otp.resend');

    Route::get('/admin/reset-password', [AdminForgotPasswordController::class, 'showResetForm'])
        ->name('admin.password.reset.form');

    Route::post('/admin/reset-password', [AdminForgotPasswordController::class, 'resetPassword'])
        ->name('admin.password.reset.update');
});

// =====================================
// Patient Login (OTP Authentication)
// =====================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login/send-otp', [AuthController::class, 'sendLoginOtp'])
        ->name('login.otp.send');

    Route::get('/login/verify-otp', [OtpController::class, 'show'])
        ->name('otp.form');

    Route::post('/login/verify-otp', [OtpController::class, 'verify'])
        ->name('otp.verify');

    Route::post('/login/resend-otp', [OtpController::class, 'resend'])
        ->name('otp.resend');
});

// =====================================
// Patient Dashboard
// =====================================
// UPDATED: now points to UserDashboardController@index (new design)
// instead of the old empty view('dashboard') placeholder.
// URL and route name are UNCHANGED (/dashboard, name: dashboard) so
// nothing else in the app that calls route('dashboard') breaks.

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');
});

// =====================================
// Protected Admin Routes
// =====================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('logout');

        // Products
        Route::resource('products', ProductController::class);

        // Orders
        Route::get('/orders/pending', function () {
            return view('admin.orders.pending');
        })->name('orders.pending');

        Route::get('/orders/completed', function () {
            return view('admin.orders.completed');
        })->name('orders.completed');

        // Settings
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });

Route::middleware('auth')->group(function () {
    Route::post('/logout', [OtpController::class, 'logout'])
        ->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Email verification success page (before redirecting to Halaxy booking)
    Route::get('/verification-success', function () {
        return view('auth.verification-success');
    })->name('verification.success');
});

// User Dashboard — extra routes (profile page, order actions, notifications)
require __DIR__ . '/user.php';

require __DIR__ . '/auth.php';
