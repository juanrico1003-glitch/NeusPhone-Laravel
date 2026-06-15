<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetAppUrlFromRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $scheme = 'https';

        // Solo usar http para localhost
        if (in_array($request->getHost(), ['localhost', '127.0.0.1'])) {
            $scheme = 'http';
        }

        $host = $scheme . '://' . $request->getHttpHost();

        config(['app.url' => $host]);
        URL::forceRootUrl($host);
        URL::forceScheme($scheme);

        return $next($request);
    }
}
