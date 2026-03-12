<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pengganti cek session role yang ada di SETIAP halaman PHP native.
     *
     * Di native setiap halaman ada:
     *   if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { ... }
     *
     * Di Laravel cukup pasang di routes/web.php:
     *   Route::middleware(['role:admin'])->group(...)
     *   Route::middleware(['role:guru'])->group(...)
     *   Route::middleware(['role:admin,guru'])->group(...)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->session()->has('user_id')) {
            return redirect()->route('login');
        }

        if (!in_array($request->session()->get('role'), $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
