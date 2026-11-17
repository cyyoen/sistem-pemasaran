<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Yang belum login diarahkan ke halaman login
        $middleware->redirectGuestsTo(fn () => route('login'));

        // Yang sudah login lalu membuka /login atau /register diarahkan sesuai perannya
        $middleware->redirectUsersTo(fn () => Auth::guard('admin')->check()
            ? route('admin.dashboard')
            : route('beranda'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();