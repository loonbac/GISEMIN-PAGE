<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Registrar middleware de autenticación simple
        $middleware->alias([
            'auth.simple' => \App\Http\Middleware\SimpleAuthMiddleware::class,
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\ForceWww::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
