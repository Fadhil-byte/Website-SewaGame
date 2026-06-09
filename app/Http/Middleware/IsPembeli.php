<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsPembeli
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'pembeli') {
            abort(403, 'Akses ditolak. Hanya pembeli yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
