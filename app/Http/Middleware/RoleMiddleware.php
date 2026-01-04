<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // jika belum login
        if (!session('login')) {
            return redirect('/');
        }

        // cek role
        if (session('role') != $role) {
            abort(403);
        }

        return $next($request);
    }
}