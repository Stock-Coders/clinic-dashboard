<?php

namespace App\Http\Middleware\custom_middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthTelescopeNoPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(!auth()->user()){
        //     return abort(404);
        // }

        if(isset(auth()->user()->email)){
            if(auth()->user()->email !== "kareemtarekpk@gmail.com" && auth()->user()->email !== "mr.hatab055@gmail.com" &&
            auth()->user()->email !== "stockcoders99@gmail.com"){
                return abort(403);
            }
        }

        return $next($request);
    }
}
