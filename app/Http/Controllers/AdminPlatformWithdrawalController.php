<?php

namespace App\Http\Controllers;

use App\Models\PlatformCommission;
use App\Models\PlatformWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AdminPlatformWithdrawalController extends Controller
{
    /**
     * Daftar bank yang tersedia.
     */
    private const BANKS = [
        'BCA',
        'BRI',
        'BNI',
        'Bank Mandiri',
        'BSI',
        'BTN',
        'CIMB Niaga',
        'Danamon',
        'Bank Permata',
        'OCBC',
        'Maybank',
        'Bank Mega',
        'Panin Bank',
        'Bank Jago',
        'SeaBank',
        'Bank Neo Commerce',
        'Bank lainnya',
    ];

    /**
     * Menampilkan saldo keuntungan dan riwayat penarikan.
     */
    public function index()
    {
        // Total komisi yang sudah diterima Sisa.in.
        $totalCommission = PlatformCommission::where(
            'collection_status',
            'paid'
        )->sum('commission_amount');

        // Total keuntungan yang sudah ditarik.
        $totalWithdrawn = PlatformWithdrawal::sum('amount');

        // Saldo keuntungan yang masih tersedia.
        $availableBalance = max(
            0,
            $totalCommission - $totalWithdrawn
        );

        // Riwayat penarikan.
        $withdrawals = PlatformWithdrawal::with('admin')
            ->latest()
            ->get();

        return view('admin.withdrawals.index', compact(
            'totalCommission',
            'totalWithdrawn',
            'availableBalance',
            'withdrawals'
        ));
    }

    /**
     * Menyimpan pencatatan penarikan keuntungan.
     */
    public function store(Request $request)
    {
        // Validasi data formulir.
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],

            'withdrawal_date' => [
                'required',
                'date',
            ],

            'bank_name' => [
                'required',
                'string',
                'in:' . implode(',', self::BANKS),
            ],

            'destination_account' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:50',
            ],

            'account_holder' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'proof' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ], [
            'amount.required' => 'Nominal penarikan wajib diisi.',
            'amount.numeric' => 'Nominal penarikan harus berupa angka.',
            'amount.min' => 'Nominal penarikan minimal Rp1.',

            'withdrawal_date.required' => 'Tanggal penarikan wajib diisi.',
            'withdrawal_date.date' => 'Format tanggal penarikan tidak valid.',

            'bank_name.required' => 'Nama bank wajib dipilih.',
            'bank_name.in' => 'Pilihan bank tidak valid.',

            'destination_account.required' => 'Nomor rekening wajib diisi.',
            'destination_account.regex' => 'Nomor rekening hanya boleh berisi angka.',
            'destination_account.max' => 'Nomor rekening maksimal 50 karakter.',

            'account_holder.required' => 'Nama pemilik rekening wajib diisi.',

            'proof.required' => 'Bukti transfer wajib diunggah.',
            'proof.mimes' => 'Bukti transfer harus berupa JPG, JPEG, PNG, atau PDF.',
            'proof.max' => 'Ukuran bukti transfer maksimal 5 MB.',
        ]);

        $proofPath = null;

        try {
            DB::transaction(function () use (
                $validated,
                $request,
                &$proofPath
            ) {
                // Mengunci data komisi yang sudah diterima.
                $commissions = PlatformCommission::where(
                    'collection_status',
                    'paid'
                )->lockForUpdate()->get();

                $totalCommission = $commissions->sum(
                    fn ($commission) => (float) $commission->commission_amount
                );

                // Menghitung seluruh penarikan sebelumnya.
                $totalWithdrawn = PlatformWithdrawal::sum('amount');

                $availableBalance = $totalCommission - $totalWithdrawn;

                // Memastikan nominal penarikan tidak melebihi saldo.
                if (
                    (float) $validated['amount'] <= 0 ||
                    (float) $validated['amount'] > $availableBalance
                ) {
                    throw ValidationException::withMessages([
                        'amount' => 'Nominal penarikan melebihi saldo keuntungan yang tersedia.',
                    ]);
                }

                // Menyimpan bukti transfer.
                $proofPath = $request->file('proof')->store(
                    'platform-withdrawals',
                    'public'
                );

                // Menggabungkan nama bank dan nomor rekening.
                $destinationAccount = $validated['bank_name']
                    . ' - '
                    . $validated['destination_account'];

                // Menyimpan transaksi penarikan.
                PlatformWithdrawal::create([
                    'withdrawal_number' => 'WD-'
                        . now()->format('YmdHis')
                        . '-'
                        . Str::upper(Str::random(5)),

                    'amount' => $validated['amount'],
                    'withdrawal_date' => $validated['withdrawal_date'],
                    'destination_account' => $destinationAccount,
                    'account_holder' => $validated['account_holder'],
                    'description' => $validated['description'] ?? null,
                    'proof' => $proofPath,
                    'admin_id' => auth()->id(),
                ]);
            });

        } catch (\Throwable $e) {
            // Menghapus bukti transfer jika transaksi gagal.
            if ($proofPath) {
                Storage::disk('public')->delete($proofPath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.withdrawals.index')
            ->with('success', 'Penarikan keuntungan berhasil dicatat.');
    }
}
