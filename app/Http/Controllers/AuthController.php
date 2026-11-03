<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'account_type' => 'required|in:customer,merchant',

            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            // Data toko wajib diisi jika mendaftar sebagai merchant
            'business_name' => 'required_if:account_type,merchant|nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required_if:account_type,merchant|nullable|string|max:20',
            'address' => 'required_if:account_type,merchant|nullable|string',
        ], [
            'account_type.required' => 'Jenis akun wajib dipilih.',
            'business_name.required_if' => 'Nama toko wajib diisi.',
            'phone.required_if' => 'Nomor telepon toko wajib diisi.',
            'address.required_if' => 'Alamat toko wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda strip, dan underscore.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        DB::transaction(function () use ($validated, &$user) {
            // Membuat akun pengguna
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['account_type'],
            ]);

            // Jika merchant, buat juga data tokonya
            if ($validated['account_type'] === 'merchant') {
                Merchant::create([
                    'user_id' => $user->id,
                    'business_name' => $validated['business_name'],
                    'description' => $validated['description'] ?? null,
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'verification_status' => 'pending',
                ]);
            }
        });

        // Customer langsung login
        if ($validated['account_type'] === 'customer') {
            auth()->login($user);

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // Merchant harus menunggu persetujuan admin
        return redirect()
            ->route('login')
            ->with('status', 'Pendaftaran merchant berhasil! Silakan menunggu verifikasi admin sebelum dapat mengakses dashboard merchant.');
    }
}
