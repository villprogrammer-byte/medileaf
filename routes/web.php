<?php
use Illuminate\Support\Facades\Http;
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
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\BlogAuthorController;
use App\Http\Controllers\Admin\BlogRedirectController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\User\UserDashboardController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/clinic', 'pages.clinic')->name('clinic');
Route::view('/gp-referral', 'pages.gp-referral')->name('gp-referral');
Route::view('/pharmacy', 'pages.pharmacy')->name('pharmacy');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/blog', 'pages.blog')->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'publicShow'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('blog.view');
Route::view('/terms', 'pages.terms')->name('terms');
Route::get('/store', [StoreController::class, 'index'])->name('store');
Route::view('/cart', 'shop.cart')->name('cart');
Route::view('/checkout', 'shop.checkout')->name('checkout');
Route::post('/contact-send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/prescription', [PrescriptionController::class, 'index'])->name('prescription');
Route::post('/prescription', [PrescriptionController::class, 'store'])->name('prescription.store');

Route::get('/upload-prescription', [UploadPrescriptionController::class, 'index'])->name('upload.prescription');
Route::post('/upload-prescription', [UploadPrescriptionController::class, 'store'])->name('upload.prescription.store');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware('guest:admin')
    ->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');

        Route::get('/login/verify-otp', [AdminOtpController::class, 'show'])->name('otp.form');
        Route::post('/login/verify-otp', [AdminOtpController::class, 'verify'])->name('otp.verify');
        Route::post('/login/resend-otp', [AdminOtpController::class, 'resend'])->name('otp.resend');
    });

Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/forgot-password', [AdminForgotPasswordController::class, 'showEmailForm'])->name('admin.password.request');
    Route::post('/admin/forgot-password/send-otp', [AdminForgotPasswordController::class, 'sendOtp'])->name('admin.password.otp.send');
    Route::get('/admin/forgot-password/verify-otp', [AdminForgotPasswordController::class, 'showOtpForm'])->name('admin.password.otp.form');
    Route::post('/admin/forgot-password/verify-otp', [AdminForgotPasswordController::class, 'verifyOtp'])->name('admin.password.otp.verify');
    Route::post('/admin/forgot-password/resend-otp', [AdminForgotPasswordController::class, 'resendOtp'])->name('admin.password.otp.resend');
    Route::get('/admin/reset-password', [AdminForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset.form');
    Route::post('/admin/reset-password', [AdminForgotPasswordController::class, 'resetPassword'])->name('admin.password.reset.update');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/send-otp', [AuthController::class, 'sendLoginOtp'])->name('login.otp.send');
    Route::get('/login/verify-otp', [OtpController::class, 'show'])->name('otp.form');
    Route::post('/login/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/login/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', ProductController::class);

        Route::get('/orders/pending', function () {
            return view('admin.orders.pending');
        })->name('orders.pending');

        Route::get('/orders/completed', function () {
            return view('admin.orders.completed');
        })->name('orders.completed');

        /*
        |--------------------------------------------------------------------------
        | BLOG
        |--------------------------------------------------------------------------
        */

        Route::prefix('blog')->name('blog.')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Categories, Tags, Authors & Redirects
            | These MUST come before /{blogPost}
            |--------------------------------------------------------------------------
            */

            Route::get('/categories', [BlogCategoryController::class, 'index'])
                ->name('categories');

            Route::post('/categories', [BlogCategoryController::class, 'store'])
                ->name('categories.store');

            Route::put('/categories/{blogCategory}', [BlogCategoryController::class, 'update'])
                ->name('categories.update');

            Route::delete('/categories/{blogCategory}', [BlogCategoryController::class, 'destroy'])
                ->name('categories.destroy');

            Route::get('/tags', [BlogTagController::class, 'index'])
                ->name('tags');

            Route::post('/tags', [BlogTagController::class, 'store'])
                ->name('tags.store');

            Route::put('/tags/{blogTag}', [BlogTagController::class, 'update'])
                ->name('tags.update');

            Route::delete('/tags/{blogTag}', [BlogTagController::class, 'destroy'])
                ->name('tags.destroy');

            Route::get('/authors', [BlogAuthorController::class, 'index'])
                ->name('authors');

            Route::post('/authors', [BlogAuthorController::class, 'store'])
                ->name('authors.store');

            Route::put('/authors/{blogAuthor}', [BlogAuthorController::class, 'update'])
                ->name('authors.update');

            Route::delete('/authors/{blogAuthor}', [BlogAuthorController::class, 'destroy'])
                ->name('authors.destroy');

            Route::get('/redirects', [BlogRedirectController::class, 'index'])
                ->name('redirects');

            Route::post('/redirects', [BlogRedirectController::class, 'store'])
                ->name('redirects.store');

            Route::put('/redirects/{blogRedirect}', [BlogRedirectController::class, 'update'])
                ->name('redirects.update');

            Route::delete('/redirects/{blogRedirect}', [BlogRedirectController::class, 'destroy'])
                ->name('redirects.destroy');

            /*
            |--------------------------------------------------------------------------
            | Blog Posts
            |--------------------------------------------------------------------------
            */

            Route::get('/', [BlogController::class, 'index'])
                ->name('index');

            Route::get('/create', [BlogController::class, 'create'])
                ->name('create');

            Route::post('/', [BlogController::class, 'store'])
                ->name('store');

            Route::get('/{blogPost}/edit', [BlogController::class, 'edit'])
                ->name('edit');

            Route::get('/{blogPost}', [BlogController::class, 'show'])
                ->name('show');

            Route::put('/{blogPost}', [BlogController::class, 'update'])
                ->name('update');

            Route::delete('/{blogPost}', [BlogController::class, 'destroy'])
                ->name('destroy');
        });

        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('logout');

        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });

Route::middleware('auth')->group(function () {
    Route::post('/logout', [OtpController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/verification-success', function () {
        return view('auth.verification-success');
    })->name('verification.success');
});

require __DIR__ . '/user.php';

require __DIR__ . '/auth.php';

Route::get('/product/{product}', [StoreController::class, 'legacyRedirect'])
    ->whereNumber('product')
    ->name('product-view.legacy');

Route::get('/{categorySlug}/{productSlug}', [StoreController::class, 'show'])
    ->where([
        'categorySlug' => '[a-z0-9\-]+',
        'productSlug' => '[a-z0-9\-]+',
    ])
    ->name('product-view');