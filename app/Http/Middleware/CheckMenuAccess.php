<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccess
{
    /**
     * Middleware hak akses berbasis menu.
     * Contoh pakai di route: ->middleware('menu:manajemen_user')
     */
    public function handle(Request $request, Closure $next, string $menuKey): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasMenuAccess($menuKey)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
