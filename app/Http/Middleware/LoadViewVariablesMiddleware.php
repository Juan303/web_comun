<?php

namespace App\Http\Middleware;
use App\Csnet\Facades\Debug;

use App\Models\Asociaciones;
use Closure;


class LoadViewVariablesMiddleware
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
        /*$asociaciones = Asociaciones::all();
        view()->share('asociaciones', $asociaciones);*/
        return $next($request);
    }
}
