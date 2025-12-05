<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek 1: Apakah user sudah login?
        // Cek 2: Apakah kolom is_admin bernilai true?
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Jika bukan admin, lempar error 403 (Forbidden) atau redirect ke home
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses admin.');
        }

        return $next($request);
    }
}