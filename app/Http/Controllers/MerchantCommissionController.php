<?php

namespace App\Http\Controllers;

use App\Models\MerchantCommissionInvoice;
use App\Models\PlatformCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MerchantCommissionController extends Controller
{
    /**
     * Menampilkan tagihan dan komisi yang belum ditagihkan.
     */
    public function index()
    {
        $merchant = auth()->user()->merchant;

        abort_unless($merchant, 403, 'Akun merchant tidak ditemukan.');

        $invoices = MerchantCommissionInvoice::where('merchant_id', $merchant->id)
            ->with('invoiceItems.commission.order')
            ->latest()
            ->get();

        $pendingCommissions = PlatformCommission::where('merchant_id', $merchant->id)
            ->where('collection_status', 'pending')
            ->with('order')
            ->orderBy('created_at')
            ->get();

        $pendingTotal = $pendingCommissions->sum('commission_amount');

        return view('merchant.commissions.index', compact(
            'merchant',
            'invoices',
            'pendingCommissions',
            'pendingTotal'
        ));
    }

    /**
     * Membuat tagihan dari seluruh komisi yang belum ditagihkan.
     */
    public function generateInvoice()
    {
        $merchant = auth()->user()->merchant;

        abort_unless($merchant, 403, 'Akun merchant tidak ditemukan.');

        $invoice = DB::transaction(function () use ($merchant) {

            $commissions = PlatformCommission::where('merchant_id', $merchant->id)
                ->where('collection_status', 'pending')
                ->orderBy('created_at')
                ->lockForUpdate()
                ->get();

            if ($commissions->isEmpty()) {
                return null;
            }

            $totalCommission = $commissions->sum(
                fn ($commission) => (float) $commission->commission_amount
            );

            $periodStart = $commissions->min('created_at')->toDateString();
            $periodEnd = $commissions->max('created_at')->toDateString();

            $newInvoice = MerchantCommissionInvoice::create([
                'merchant_id' => $merchant->id,
                'invoice_number' => 'KOM-' . $merchant->id . '-' .
                    now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'total_commission' => $totalCommission,
                'status' => 'unpaid',
                'due_date' => null,
            ]);

            foreach ($commissions as $commission) {
                $newInvoice->invoiceItems()->create([
                    'commission_id' => $commission->id,
                ]);

                $commission->update([
                    'collection_status' => 'invoiced',
                ]);
            }

            return $newInvoice;
        });

        if (!$invoice) {
            return back()->with('error', 'Belum ada komisi yang bisa ditagihkan.');
        }

        return redirect()
            ->route('merchant.commissions.index')
            ->with('success', 'Tagihan komisi berhasil dibuat.');
    }

    /**
     * Merchant mengunggah bukti transfer komisi.
     */
    public function uploadProof(Request $request, $invoiceId)
    {
        $merchant = auth()->user()->merchant;

        abort_unless($merchant, 403, 'Akun merchant tidak ditemukan.');

        $validated = $request->validate([
            'payment_proof' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
            'payment_reference' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'payment_proof.required' => 'Bukti transfer wajib diunggah.',
            'payment_proof.mimes' => 'Format bukti harus JPG, JPEG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti transfer maksimal 5 MB.',
        ]);

        $invoice = MerchantCommissionInvoice::where('merchant_id', $merchant->id)
            ->findOrFail($invoiceId);

        if (!in_array($invoice->status, ['unpaid', 'overdue'])) {
            return back()->with(
                'error',
                'Tagihan ini tidak dapat menerima bukti transfer.'
            );
        }

        $oldProof = $invoice->payment_proof;

        $path = $request->file('payment_proof')
            ->store('commission-proofs', 'public');

        try {
            DB::transaction(function () use ($invoice, $validated, $path) {
                $invoice->update([
                    'payment_proof' => $path,
                    'payment_method' => 'bank_transfer',
                    'payment_reference' => $validated['payment_reference'] ?? null,
                    'status' => 'pending_verification',
                    'submitted_at' => now(),
                    'rejection_reason' => null,
                    'verified_by' => null,
                    'verified_at' => null,
                ]);
            });
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($path);

            throw $e;
        }

        if ($oldProof) {
            Storage::disk('public')->delete($oldProof);
        }

        return redirect()
            ->route('merchant.commissions.index')
            ->with(
                'success',
                'Bukti transfer berhasil dikirim. Menunggu verifikasi Admin.'
            );
    }
}
