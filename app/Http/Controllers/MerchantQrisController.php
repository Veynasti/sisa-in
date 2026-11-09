<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MerchantQrisController extends Controller
{
    // Menampilkan halaman pengaturan QRIS
    public function index()
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        return view('merchant.qris.index', compact('merchant'));
    }

    // Menyimpan atau mengganti gambar QRIS
    public function store(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'qris_image.required' => 'Silakan pilih gambar QRIS terlebih dahulu.',
            'qris_image.image' => 'File harus berupa gambar.',
            'qris_image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'qris_image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        // Simpan gambar QRIS baru
        $newPath = $request->file('qris_image')
            ->store('qris', 'public');

        // Hapus gambar QRIS lama jika tersedia
        if ($merchant->qris_image) {
            Storage::disk('public')->delete($merchant->qris_image);
        }

        $merchant->qris_image = $newPath;
        $merchant->save();

        return redirect()
            ->route('merchant.qris.index')
            ->with('success', 'Gambar QRIS berhasil disimpan.');
    }
}
