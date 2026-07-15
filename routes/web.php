<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Prescription\PrescriptionController;
use App\Http\Controllers\Prescription\UploadPrescriptionController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\StoreController;
;

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

Route::view('/product-view', 'shop.product-view')
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


// Admin Login
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminLoginController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout');

// =====================================
// Admin Routes
// =====================================

Route::prefix('admin')
    ->middleware(['auth', 'verified'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
