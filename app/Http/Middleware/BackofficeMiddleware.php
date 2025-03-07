<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BackofficeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // if (!auth()->check() || auth()->user()->role !== 'admin') {
        //     return redirect('/login')->with('error', 'Anda tidak memiliki akses ke backoffice.');
        // }
        dd(session()->all());
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        return $next($request);
    }
}
