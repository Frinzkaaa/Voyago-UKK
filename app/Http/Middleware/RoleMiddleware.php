<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Handle both Enum and string roles
        $userRole = $user->role;
        $currentRole = ($userRole instanceof \BackedEnum) ? $userRole->value : $userRole;

        // PRIORITAS: Admin boleh mengakses apapun (admin, partner, user)
        if ($currentRole === 'admin') {
            return $next($request);
        }

        // Penanganan Khusus: Partner boleh akses halaman user publik 
        // (tapi routes/web.php kita untuk user biasanya tidak pakai middleware role:user)

        if ($currentRole !== $role) {
            // Jika role tidak sesuai, arahkan ke dashboard yang sesuai (bukan 403)
            if ($currentRole === 'partner') {
                return redirect()->route('partner.dashboard')->with('error', 'Anda login sebagai Mitra. Tidak bisa mengakses halaman ' . $role);
            }

            return redirect()->route('beranda')->with('error', 'Akses ditolak. Anda tidak memiliki role ' . $role);
        }

        return $next($request);
    }
}
