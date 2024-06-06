<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
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

        //if super admin
        if ($userRole == 1) {
            return redirect()->route("superAdmin.dashboard");
        }

        //if admin
        if ($userRole == 2) {
            return redirect()->route("admin.dashboard");
        }

        //if user
        if ($userRole == 3) {
            return $next($request);
        }

    }
}
