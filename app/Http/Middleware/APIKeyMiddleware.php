<?php

namespace App\Http\Middleware;

use Closure;

class APIKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('api_key')) {

            return $next($request);
        }
        return response(['Unauthorized'], 401);

    }

}   