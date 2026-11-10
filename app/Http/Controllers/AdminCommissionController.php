<?php

namespace App\Http\Controllers;

use App\Models\MerchantCommissionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCommissionController extends Controller
{
    /**
     * Menampilkan daftar setoran komisi yang menunggu verifikasi.
     */
    public function index()
    {
        $invoices = MerchantCommissionInvoice::with([
                'merchant.user',
                'invoiceItems.commission.order',
            ])
            ->where('status', 'pending_verification')
            ->latest('submitted_at')
            ->get();

        $pendingCount = MerchantCommissionInvoice::where(
            'status',
            'pending_verification'
        )->count();

        $pendingTotal = MerchantCommissionInvoice::where(
            'status',
            'pending_verification'
        )->sum('total_commission');

        $approvedCount = MerchantCommissionInvoice::where(
            'status',
            'paid'
        )->count();

        return view('admin.commissions.index', compact(
            'invoices',
            'pendingCount',
            'pendingTotal',
            'approvedCount'
        ));
    }


    /**
     * Menyetujui pembayaran setoran komisi.
     */
    public function approve($invoiceId)
    {
        DB::transaction(function () use ($invoiceId) {

            $invoice = MerchantCommissionInvoice::whereKey($invoiceId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($invoice->status !== 'pending_verification') {
                abort(422, 'Tagihan ini tidak sedang menunggu verifikasi.');
            }

            // Mengubah status invoice menjadi lunas.
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'rejection_reason' => null,
            ]);

            // Mengubah seluruh komisi dalam invoice menjadi lunas.
            $invoice->commissions()->update([
                'collection_status' => 'paid',
            ]);
        });

        return redirect()
            ->route('admin.commissions.index')
            ->with('success', 'Setoran komisi berhasil diverifikasi dan disetujui.');
    }


    /**
     * Menolak pembayaran setoran komisi.
     */
    public function reject(Request $request, $invoiceId)
    {
        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        DB::transaction(function () use ($invoiceId, $validated) {

            $invoice = MerchantCommissionInvoice::whereKey($invoiceId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($invoice->status !== 'pending_verification') {
                abort(422, 'Tagihan ini tidak sedang menunggu verifikasi.');
            }

            // Invoice kembali menjadi belum dibayar.
            $invoice->update([
                'status' => 'unpaid',
                'rejection_reason' => $validated['rejection_reason'],
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'paid_at' => null,
            ]);
        });

        return redirect()
            ->route('admin.commissions.index')
            ->with('success', 'Setoran komisi ditolak. Merchant dapat mengunggah ulang bukti transfer.');
    }
}
