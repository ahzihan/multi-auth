<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if no user
        if (!Auth::check()) {
            return redirect()->route("login");
        }

        //check and next step
        $userRole = Auth::user()->role;

        if ($userRole == 1) {
            return redirect()->route("superAdmin.dashboard");
        } elseif ($userRole == 2) {
            return $next($request);
        } elseif ($userRole == 3) {
            return redirect()->route("user.dashboard");
        }

    }
}
