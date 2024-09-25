<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AdminRedirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.guest' => \App\Http\Middleware\AdminRedirect::class,
            'admin.auth' => \App\Http\Middleware\AdminAuthenticate::class,
        ]);


        $middleware->redirectTo(
            guests: '/adminStudent/login',
            users: '/adminStudent/dashboard',
        );

        // এখানে, $middleware->redirectTo(guests: '/adminStudent/login', users: '/adminStudent/dashboard'); এর কাজ হলো guest এবং auth middleware এর জন্য রিডাইরেকশন ঠিক করা।

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
