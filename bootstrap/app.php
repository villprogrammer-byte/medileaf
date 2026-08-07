<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Guest Redirects
        |--------------------------------------------------------------------------
        |
        | Normal protected pages -> /login
        | Admin protected pages  -> /admin/login
        |
        */

        $middleware->redirectGuestsTo(function (Request $request) {
            return $request->is('admin/*')
                ? '/admin/login'
                : '/login';
        });

        /*
        |--------------------------------------------------------------------------
        | Already Authenticated Redirects
        |--------------------------------------------------------------------------
        |
        | Logged-in user visiting /login       -> /dashboard
        | Logged-in admin visiting /admin/login -> /admin/dashboard
        |
        */

        $middleware->redirectUsersTo(function (Request $request) {
            return $request->is('admin/*')
                ? '/admin/dashboard'
                : '/dashboard';
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();