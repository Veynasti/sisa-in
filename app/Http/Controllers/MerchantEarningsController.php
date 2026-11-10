<?php

namespace App\Http\Controllers;

use App\Models\PlatformCommission;

class MerchantEarningsController extends Controller
{
    /**
     * Menampilkan ringkasan keuntungan bersih merchant.
     */
    public function index()
    {
        $merchant = auth()->user()->merchant;

        abort_unless($merchant, 403, 'Data merchant tidak ditemukan.');

        // Mengambil seluruh transaksi yang sudah dikonfirmasi
        $commissionsQuery = PlatformCommission::where(
            'merchant_id',
            $merchant->id
        );

        // Ringkasan keuangan merchant
        $totalTransactions = (clone $commissionsQuery)->count();

        $totalSales = (clone $commissionsQuery)
            ->sum('gross_amount');

        $totalCommission = (clone $commissionsQuery)
            ->sum('commission_amount');

        $netProfit = (clone $commissionsQuery)
            ->sum('merchant_amount');

        // Riwayat transaksi
        $commissions = (clone $commissionsQuery)
            ->with('order')
            ->latest()
            ->paginate(10);

        return view('merchant.earnings.index', compact(
            'merchant',
            'totalTransactions',
            'totalSales',
            'totalCommission',
            'netProfit',
            'commissions'
        ));
    }
}
