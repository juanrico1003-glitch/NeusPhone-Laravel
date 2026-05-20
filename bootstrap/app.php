<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    // Configuración de rutas principales
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    // Registro de middlewares personalizados
    ->withMiddleware(function (Middleware $middleware) {
        // Excepciones de CSRF para el Chatbot
        $middleware->validateCsrfTokens(except: [
            'chatbot',
        ]);

        // Correccion del alias para el middleware admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })

    // Configuracion de manejo de errores
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();