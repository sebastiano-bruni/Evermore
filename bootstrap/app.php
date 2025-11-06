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
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Diciamo a Laravel: "Quando stai per MOSTRARE un errore
        // di tipo AuthenticationException..."
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {

            // "...controlla se la richiesta NON è un'API (quindi è un browser)"
            if (! $request->expectsJson()) {

                // "e in quel caso, reindirizza alla homepage."
                return redirect()->route('home');
            }
        });
    })->create();
