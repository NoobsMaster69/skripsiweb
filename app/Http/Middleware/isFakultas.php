<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isFakultas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array(Auth::user()->jabatan, ['fakultas', 'admin'])) {
            return $next($request);
        } else {
            return redirect()->route('dashboard')->with(
                'error',
                'Anda tidak memiliki akses ke halaman ini'
            );
        }
    }
}
