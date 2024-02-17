<?php

namespace App\Http\Middleware\custom_middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && isset(auth()->user()->user_type)){
            if(auth()->user()->user_type !== "doctor" && auth()->user()->user_type !== "employee" &&
            auth()->user()->user_type !== "developer"){
                return abort(403);
            }
        }
        return $next($request);
    }
}
