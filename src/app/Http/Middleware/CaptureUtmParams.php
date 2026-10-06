<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureUtmParams
{
    private const UTM_KEYS = [
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach (self::UTM_KEYS as $key) {
            $value = $request->query($key);
            if ($value !== null && $value !== '') {
                $request->session()->put($key, $value);
            }
        }

        return $next($request);
    }
}
