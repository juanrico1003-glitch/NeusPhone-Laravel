<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAppUrlFromRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        // Set APP_URL dynamically based on the request's host
        config([
            'app.url' => $request->getSchemeAndHttpHost(),
        ]);

        return $next($request);
    }
}
