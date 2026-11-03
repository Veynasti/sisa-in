<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Memeriksa username dan password
        if (Auth::attempt([
            'username' => $validated['username'],
            'password' => $validated['password'],
        ])) {

            $user = Auth::user();

            // Pemeriksaan khusus untuk akun Merchant
            if ($user->role === 'merchant') {

                $merchant = $user->merchant;

                // Merchant belum memiliki data toko
                if (!$merchant) {
                    Auth::logout();

                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'username' => 'Data toko tidak ditemukan. Silakan hubungi admin.',
                    ])->onlyInput('username');
                }

                // Merchant belum disetujui atau ditolak
                if ($merchant->verification_status !== 'approved') {

                    $message = match ($merchant->verification_status) {
                        'pending' => 'Pendaftaran toko kamu masih menunggu verifikasi admin.',
                        'rejected' => 'Pendaftaran toko kamu ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
                        default => 'Status verifikasi toko tidak valid. Silakan hubungi admin.',
                    };

                    Auth::logout();

                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'username' => $message,
                    ])->onlyInput('username');
                }
            }

            // Jika lolos pemeriksaan, buat session baru
            $request->session()->regenerate();

            // Arahkan pengguna berdasarkan role
            return match ($user->role) {
                'merchant' => redirect()->route('merchant.dashboard'),
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('dashboard'),
            };
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
