<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Memeriksa role pengguna
        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Memeriksa status verifikasi merchant
        if (
            $user->role === 'merchant' &&
            $user->merchant?->verification_status !== 'approved'
        ) {
            $status = $user->merchant?->verification_status;

            $message = match ($status) {
                'pending' => 'Pendaftaran toko kamu masih menunggu verifikasi admin.',
                'rejected' => 'Pendaftaran toko kamu ditolak. Silakan hubungi admin.',
                default => 'Data verifikasi toko tidak ditemukan. Silakan hubungi admin.',
            };

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors(['username' => $message]);
        }

        return $next($request);
    }
}
