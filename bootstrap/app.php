<?php

use App\Http\Middleware\isProdi;
use App\Http\Middleware\checkLogin;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\isAdminBpm;
use App\Http\Middleware\isFakultas;
use Illuminate\Foundation\Application;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // middleware bawaan Laravel
            'auth'        => Authenticate::class,
            // middleware kustom untuk cek role
            'role'        => CheckRole::class,
            'checkLogin' => checkLogin::class,
            'isAdminBpm'    => isAdminBpm::class,
            'isFakultas'    => isFakultas::class,
            'isProdi'    => isProdi::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
