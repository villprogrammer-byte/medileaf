<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Prescription\PrescriptionController;
use App\Http\Controllers\Prescription\UploadPrescriptionController;

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
Route::view('/store', 'shop.store')->name('store');
Route::view('/product-view', 'shop.product-view')->name('product-view');
Route::view('/cart', 'shop.cart')->name('cart');
Route::view('/checkout', 'shop.checkout')->name('checkout');

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

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
