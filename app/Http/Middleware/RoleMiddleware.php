<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        // Jika user tidak terautentikasi, maka redirect ke halaman login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Jika user tidak memiliki role yang diizinkan, maka redirect ke halaman utama dengan pesan error
        if (!$request->user()->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman tersebut.');
        }

        return $next($request);
    }
}
