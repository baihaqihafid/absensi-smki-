<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pengganti logika cek session role yang ada di setiap halaman PHP native.
     *
     * Contoh PHP native di setiap halaman:
     *   if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
     *       header("Location: ../pages/login.php");
     *       exit;
     *   }
     *
     * Di Laravel cukup pasang di routes/web.php:
     *   Route::middleware(['role:admin'])->group(...)
     *   Route::middleware(['role:guru'])->group(...)
     *   Route::middleware(['role:admin,guru'])->group(...)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login
        if (!$request->session()->has('user_id')) {
            return redirect()->route('login');
        }

        // Role tidak sesuai
        if (!in_array($request->session()->get('role'), $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
