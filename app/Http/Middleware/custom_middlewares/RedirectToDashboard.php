<?php

namespace App\Http\Middleware\custom_middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // // Method (1):
        //     $currentUrl = $request->url(); // Get the current URL
        //     // Check if the current URL is localhost:8000
        //     if ($currentUrl === 'http://localhost:8000') {
        //         return redirect()->route('dashboard');
        //     }
        // // Method (2):
        //     // $currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //     // if($currentUrl === 'http://localhost:8000/'){
        //     //     return redirect()->route('dashboard');
        //     // }
        return redirect()->route('dashboard');
        return $next($request);
    }
}
