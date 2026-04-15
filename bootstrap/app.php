<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    // Configuración de rutas principales
    ->withRouting(
        web: __DIR__.'/../routes/web.php',      // Rutas web
        commands: __DIR__.'/../routes/console.php', // Comandos artisan
        health: '/up', // Ruta de verificación del servidor
    )

    // Registro de middlewares personalizados
    ->withMiddleware(function (Middleware $middleware) {

        // Creamos el alias 'admin' para usarlo en las rutas
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })

    // Configuración de manejo de errores
    ->withExceptions(function (Exceptions $exceptions) {
        // Se usa la configuración por defecto
    })

    ->create();
