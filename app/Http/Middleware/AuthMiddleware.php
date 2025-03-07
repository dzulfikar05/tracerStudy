<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna belum login, redirect ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $next($request); // Lanjutkan ke halaman yang diminta jika sudah login
    }
}
