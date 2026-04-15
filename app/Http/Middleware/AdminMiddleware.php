<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificamos que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Verificamos que el rol sea admin (id = 1)
        if (auth()->user()->rol_id != 1) {
            return redirect('/tienda');
        }

        return $next($request);
    }
}
