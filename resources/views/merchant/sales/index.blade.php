@extends('layouts.merchant')

@section('title', 'Riwayat Penjualan - Sisa.in')
@section('page-title', 'Riwayat Penjualan')
@section('page-description', 'Pantau seluruh transaksi dan pendapatan dari penjualan tokomu.')

@section('content')

<div class="space-y-6">

    {{-- RINGKASAN PENJUALAN --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

        {{-- TOTAL TRANSAKSI --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Transaksi
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-gray-800">
                        {{ number_format($totalTransactions, 0, ',', '.') }}
                    </h3>

                    <p class="mt-2 text-xs text-gray-400">
                        Transaksi berhasil dibayar
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7h6m-6 4h6"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- TOTAL PENJUALAN --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Penjualan
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-green-700">
                        Rp{{ number_format($totalSales, 0, ',', '.') }}
                    </h3>

                    <p class="mt-2 text-xs text-gray-400">
                        Akumulasi nilai produk terjual
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 2v8m0 0v2m8-6a8 8 0 11-16 0 8 8 0 0116 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- PENCARIAN DAN FILTER --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-800">
                Cari Transaksi
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Cari transaksi berdasarkan pesanan, pelanggan, produk, atau tanggal.
            </p>
        </div>

        <form action="{{ route('merchant.sales.index') }}" method="GET">

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">

                {{-- PENCARIAN --}}
                <div class="lg:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-medium text-gray-700">
                        Kata Kunci
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Kode pesanan, pelanggan, atau produk..."
                            class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>
                </div>

                {{-- TANGGAL AWAL --}}
                <div>
                    <label for="start_date" class="mb-2 block text-sm font-medium text-gray-700">
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ $filters['start_date'] ?? '' }}"
                        max="{{ $filters['end_date'] ?? date('Y-m-d') }}"
                        class="w-full rounded-xl border border-gray-200 px-3 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                </div>

                {{-- TANGGAL AKHIR --}}
                <div>
                    <label for="end_date" class="mb-2 block text-sm font-medium text-gray-700">
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ $filters['end_date'] ?? '' }}"
                        min="{{ $filters['start_date'] ?? '' }}"
                        max="{{ date('Y-m-d') }}"
                        class="w-full rounded-xl border border-gray-200 px-3 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                </div>

            </div>

            {{-- TOMBOL FILTER --}}
            <div class="mt-5 flex flex-wrap items-center gap-3">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    Cari Transaksi
                </button>

                <a
                    href="{{ route('merchant.sales.index') }}"
                    class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                >
                    Reset Filter
                </a>

            </div>

        </form>

    </div>

    {{-- TABEL RIWAYAT PENJUALAN --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        <div class="border-b border-gray-100 px-6 py-5">
            <h3 class="text-lg font-bold text-gray-800">
                Riwayat Transaksi
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Menampilkan {{ number_format($orders->total(), 0, ',', '.') }} transaksi berdasarkan pencarian dan filter yang dipilih.
            </p>
        </div>

        @if($orders->count() > 0)

            <div class="overflow-x-auto">
                <table class="w-full min-w-212.5 text-left">

                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="px-6 py-4">Pesanan</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Pembayaran</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($orders as $order)

                            <tr class="transition hover:bg-gray-50">

                                {{-- KODE PESANAN --}}
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-800">
                                        {{ $order->order_code }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        #{{ $order->id }}
                                    </p>
                                </td>

                                {{-- PELANGGAN --}}
                                <td class="px-6 py-5">
                                    <p class="font-medium text-gray-700">
                                        {{ $order->user->name ?? 'Pelanggan' }}
                                    </p>
                                </td>

                                {{-- PRODUK --}}
                                <td class="px-6 py-5">
                                    @foreach($order->items as $item)
                                        <div class="mb-1">
                                            <p class="font-medium text-gray-700">
                                                {{ $item->product->name ?? 'Produk dihapus' }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                {{ $item->quantity }} item
                                            </p>
                                        </div>
                                    @endforeach
                                </td>

                                {{-- TANGGAL --}}
                                <td class="px-6 py-5">
                                    <p class="text-sm text-gray-700">
                                        {{ $order->created_at->format('d M Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $order->created_at->format('H:i') }} WIB
                                    </p>
                                </td>

                                {{-- TOTAL --}}
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-800">
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </td>

                                {{-- METODE PEMBAYARAN --}}
                                <td class="px-6 py-5">
                                    @if($order->payment?->payment_method === 'qris')
                                        <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                            QRIS
                                        </span>
                                    @elseif($order->payment?->payment_method === 'cod')
                                        <span class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-700">
                                            COD
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">
                                            -
                                        </span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-5">
                                    @if($order->status === 'completed')
                                        <span class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                                            Selesai
                                        </span>
                                    @elseif($order->status === 'ready_for_pickup')
                                        <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                            Siap Diambil
                                        </span>
                                    @elseif($order->status === 'paid')
                                        <span class="rounded-lg bg-yellow-50 px-3 py-1.5 text-xs font-semibold text-yellow-700">
                                            Dibayar
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $orders->links() }}
            </div>

        @else

            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center px-6 py-16 text-center">

                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-50">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 14l2 2 4-4m5-5v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z"/>
                    </svg>
                </div>

                <h3 class="mt-5 text-lg font-semibold text-gray-800">
                    Tidak Ada Transaksi
                </h3>

                <p class="mt-2 max-w-sm text-sm text-gray-500">
                    Belum ada transaksi yang sesuai dengan pencarian atau filter yang kamu pilih.
                </p>

                <a
                    href="{{ route('merchant.sales.index') }}"
                    class="mt-5 rounded-xl bg-green-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800"
                >
                    Reset Pencarian
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
