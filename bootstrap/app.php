<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    // Configuración de rutas principales
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    // Registro de middlewares personalizados
    ->withMiddleware(function (Middleware $middleware) {
        // Set APP_URL dynamically from request host
        $middleware->append(\App\Http\Middleware\SetAppUrlFromRequest::class);

        // Excepciones de CSRF para el Chatbot
        $middleware->validateCsrfTokens(except: [
            'chatbot',
            'wompi/webhook',
        ]);

        // Correccion del alias para el middleware admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'cache.response' => \App\Http\Middleware\CacheResponse::class,
        ]);
    })

    // Configuracion de manejo de errores
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();