<?php

namespace App\Http\Middleware\custom_middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserActivityLogOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check user's last activity timestamp
            $lastActivity = $user->last_activity;

            // Set your AFK timeout duration (in seconds)
            $afkTimeout = 120; // 2 minutes ( 2 minutes * 60 seconds = 120 seconds)

            // Log the user out if they are inactive
            if (now()->diffInSeconds($lastActivity) > $afkTimeout) {
                session(['intended_url' => url()->current()]); // get the current url before logging out (the rest of the logic is in the "LoginController.php" controller in the "authenticated" method)
                Auth::logout(); // calling log out class & method functionality
                return redirect()->route('dashboard.login')->with('inactivityLogoutMsg', 'You have been logged out due to inactivity.');
            }

            // Update user's last activity timestamp
            $user->update(['last_activity' => now()]);
        }
        return $next($request);
    }
}
