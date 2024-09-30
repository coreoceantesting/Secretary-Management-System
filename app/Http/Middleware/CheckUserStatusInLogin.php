<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatusInLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->active_status == "1") {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->active_status == "0") {
            Auth::logout();
            return redirect()->route('login');
        } else {
            return $next($request);
        }
    }
}
