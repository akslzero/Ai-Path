<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Kalau belum login → lewat dulu, biarkan Filament yang handle login
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Kalau profil user belum ada → anggap member (atau set default)
        $role = $user->profile->role ?? 'member';

        // Kalau role tidak cocok → tolak
        if (!in_array($role, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
