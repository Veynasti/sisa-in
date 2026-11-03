<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class AdminMerchantController extends Controller
{
    /**
     * Menampilkan daftar merchant.
     */
    public function index()
    {
        $merchants = Merchant::with('user')
            ->latest()
            ->get();

        $pendingCount = Merchant::where('verification_status', 'pending')->count();
        $approvedCount = Merchant::where('verification_status', 'approved')->count();
        $rejectedCount = Merchant::where('verification_status', 'rejected')->count();

        return view('admin.merchants.index', compact(
            'merchants',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Memproses persetujuan atau penolakan merchant.
     */
    public function updateStatus(Request $request, Merchant $merchant)
    {
        $validated = $request->validate([
            'verification_status' => 'required|in:approved,rejected',
        ]);

        $merchant->update([
            'verification_status' => $validated['verification_status'],
        ]);

        $message = $validated['verification_status'] === 'approved'
            ? 'Pendaftaran merchant berhasil disetujui.'
            : 'Pendaftaran merchant berhasil ditolak.';

        return redirect()
            ->route('admin.merchants.index')
            ->with('success', $message);
    }
}
