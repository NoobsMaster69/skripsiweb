<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Jika belum login atau role user tidak ada di daftar $roles → abort
        if (! $user || ! in_array($user->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
