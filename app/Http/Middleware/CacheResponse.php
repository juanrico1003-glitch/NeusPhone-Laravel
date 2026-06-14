<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    public function handle(Request $request, Closure $next, int $minutes = 10): Response
    {
        if ($request->user() || $request->method() !== 'GET' || app()->environment('testing')) {
            return $next($request);
        }

        $key = 'page_cache_' . md5($request->fullUrl());
        
        if (Cache::has($key)) {
            $cached = Cache::get($key);
            return response($cached['content'], $cached['status'])
                ->withHeaders($cached['headers']);
        }

        $response = $next($request);

        if ($response->isSuccessful()) {
            Cache::put($key, [
                'content' => $response->getContent(),
                'status' => $response->getStatusCode(),
                'headers' => $response->headers->all(),
            ], now()->addMinutes($minutes));
        }

        return $response;
    }
}
