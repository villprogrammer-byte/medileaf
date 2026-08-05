<?php

use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // Each sidebar menu item now has its OWN route + page (same behaviour
    // as the admin sidebar: clicking one menu item shows ONLY that
    // section, not everything at once).
    Route::get('/treatment', [UserDashboardController::class, 'treatment'])->name('treatment');
    Route::get('/prescriptions', [UserDashboardController::class, 'prescription'])->name('prescriptions');
    Route::get('/appointments', [UserDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');

    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [UserDashboardController::class, 'changePassword'])->name('profile.password');

    Route::get('/orders/{order}/track', [UserDashboardController::class, 'trackOrder'])->name('orders.track');
    Route::get('/orders/{order}/invoice', [UserDashboardController::class, 'downloadInvoice'])->name('orders.invoice');

    Route::post('/notifications/read-all', [UserDashboardController::class, 'markAllNotificationsRead'])->name('notifications.read_all');

});
