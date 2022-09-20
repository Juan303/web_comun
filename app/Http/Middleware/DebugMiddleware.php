<?php

namespace App\Http\Middleware;
use App\Csnet\Facades\Debug;

use Closure;


class DebugMiddleware
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
        Debug::setDatabase();
        return $next($request);
    }
}
