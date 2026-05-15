<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->is_guest) {
            return redirect('/')->with('error', 'Akses ditolak. Hanya tamu yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
