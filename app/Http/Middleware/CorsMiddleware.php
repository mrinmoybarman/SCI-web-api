<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        // Allow OPTIONS request to bypass authentication
        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $this->corsHeaders());
        }

        $response = $next($request);

        foreach ($this->corsHeaders() as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }

    private function corsHeaders()
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
        ];
    }
}
