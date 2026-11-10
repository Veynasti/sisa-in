@extends('layouts.merchant')

@section('title', 'Keuntungan Bersih - Sisa.in')
@section('page-title', 'Keuntungan Bersih')
@section('page-description', 'Pantau total penjualan, komisi platform, dan keuntungan bersih dari transaksi tokomu.')

@section('content')

<div class="space-y-6">

    {{-- RINGKASAN KEUANGAN --}}
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL PENJUALAN --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">Total Penjualan</p>
                <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 3v18h18M7 14l4-4 4 4 6-7"/>
                    </svg>
                </div>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-gray-800">
                Rp{{ number_format($totalSales, 0, ',', '.') }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Total transaksi terkonfirmasi</p>
        </div>

        {{-- TOTAL KOMISI --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">Komisi Sisa.in</p>
                <div class="rounded-xl bg-orange-50 p-3 text-orange-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-2.2 0-4 1.1-4 2.5S9.8 13 12 13s4 1.1 4 2.5S14.2 18 12 18m0-10V6m0 2v10m0 0v2"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-orange-600">
                Rp{{ number_format($totalCommission, 0, ',', '.') }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Komisi platform sebesar 5%</p>
        </div>

        {{-- KEUNTUNGAN BERSIH --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">Keuntungan Bersih</p>
                <div class="rounded-xl bg-green-50 p-3 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-green-600">
                Rp{{ number_format($netProfit, 0, ',', '.') }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Penjualan setelah dikurangi komisi</p>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                <div class="rounded-xl bg-purple-50 p-3 text-purple-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>
                </div>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-gray-800">
                {{ number_format($totalTransactions, 0, ',', '.') }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Transaksi yang sudah dikonfirmasi</p>
        </div>

    </div>

    {{-- INFORMASI PERHITUNGAN --}}
    <div class="rounded-2xl border border-green-100 bg-green-50 p-5">
        <div class="flex items-start gap-3">
            <div class="rounded-lg bg-white p-2 text-green-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 110-20 10 10 0 010 20z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-green-800">Informasi Perhitungan Keuntungan</h3>
                <p class="mt-1 text-sm leading-relaxed text-green-700">
                    Keuntungan bersih dihitung dari total penjualan dikurangi komisi
                    platform Sisa.in sebesar 5%. Perhitungan ini merupakan laporan
                    keuntungan dan tidak berarti komisi sudah disetorkan kepada platform.
                </p>
            </div>
        </div>
    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        <div class="flex flex-col gap-2 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Riwayat Keuntungan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Rincian penjualan dan keuntungan dari setiap transaksi.
                </p>
            </div>
            <span class="text-sm text-gray-500">
                {{ $commissions->total() }} transaksi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm">

                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No.</th>
                        <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-right font-semibold">Penjualan</th>
                        <th class="px-6 py-4 text-right font-semibold">Komisi (5%)</th>
                        <th class="px-6 py-4 text-right font-semibold">Keuntungan Bersih</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($commissions as $index => $commission)
                        <tr class="transition hover:bg-gray-50">

                            <td class="px-6 py-4 text-gray-500">
                                {{ $commissions->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $commission->order->order_code ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $commission->created_at->format('d M Y, H:i') }}
                            </td>

                            <td class="px-6 py-4 text-right text-gray-700">
                                Rp{{ number_format($commission->gross_amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right text-orange-600">
                                Rp{{ number_format($commission->commission_amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right font-semibold text-green-600">
                                Rp{{ number_format($commission->merchant_amount, 0, ',', '.') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="rounded-full bg-gray-100 p-4 text-gray-400">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                                        </svg>
                                    </div>
                                    <p class="mt-3 font-medium text-gray-700">
                                        Belum ada riwayat keuntungan
                                    </p>
                                    <p class="mt-1 text-sm text-gray-400">
                                        Keuntungan akan muncul setelah pembayaran pesanan dikonfirmasi.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($commissions->hasPages())
            <div class="border-t border-gray-100 px-5 py-4">
                {{ $commissions->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
