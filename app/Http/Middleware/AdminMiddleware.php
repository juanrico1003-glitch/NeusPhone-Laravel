<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificamos que el usuario este autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verificamos que el rol sea admin
        if (Auth::user()->rol_id != 1) {
            return redirect('/tienda');
        }

        return $next($request);
    }
}
