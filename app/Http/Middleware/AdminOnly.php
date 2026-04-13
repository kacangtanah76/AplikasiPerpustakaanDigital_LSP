<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin role
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // If user is authenticated but not admin, redirect to dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin');
        }

        // If not authenticated, redirect to login
        return redirect()->route('login');
    }
}
