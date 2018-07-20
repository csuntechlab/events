<?php

namespace App\Http\Middleware;

use Closure;

class APIKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($request->ajax()) {
//            return response('Unauthorized.', 401);
//       }

        if (!$request->has('api_key')) {

            return response('Check API key');

        }

        return $next($request);

    }
}
