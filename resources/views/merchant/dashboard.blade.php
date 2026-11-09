@extends('layouts.merchant')

@section('title', 'Dashboard Merchant - Sisa.in')

@section('page-title', 'Dashboard')

@section('page-description', 'Kelola aktivitas toko Anda.')

@section('content')

    {{-- WELCOME --}}
    <section class="mb-8">
        <p class="mb-2 text-sm font-medium text-green-700">
            MERCHANT CENTER
        </p>

        <h2 class="text-2xl font-bold text-gray-900 md:text-3xl">
            Selamat datang, {{ auth()->user()->name }}!
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            Pantau dan kelola aktivitas toko Anda melalui halaman ini.
        </p>
    </section>

    {{-- STORE BANNER --}}
    <section class="mb-8 rounded-2xl bg-linear-to-r from-[#174b35] to-[#286c4b] p-7 text-white lg:p-9">

        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-green-200">
            Toko Anda
        </p>

        <h3 class="text-2xl font-bold md:text-3xl">
            {{ auth()->user()->merchant?->business_name ?? 'Nama Toko' }}
        </h3>

        <p class="mt-3 max-w-xl text-sm leading-relaxed text-green-100">
            Kelola produk surplus, pantau pesanan customer,
            dan bantu mengurangi food waste bersama Sisa.in.
        </p>

    </section>

    {{-- SUMMARY CARDS --}}
    <section class="mb-9">

        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-900">
                Ringkasan Aktivitas
            </h3>

            <p class="mt-1 text-sm text-gray-400">
                Informasi aktivitas toko Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- PRODUK AKTIF --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-700">
                    <span class="text-xl">📦</span>
                </div>

                <p class="text-sm text-gray-500">
                    Produk Aktif
                </p>

                <h4 class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($activeProducts) }}
                </h4>

                <p class="mt-2 text-xs text-gray-400">
                    Jumlah produk tersedia
                </p>

            </div>

            {{-- PESANAN MASUK --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                    <span class="text-xl">🛍️</span>
                </div>

                <p class="text-sm text-gray-500">
                    Pesanan Masuk
                </p>

                <h4 class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($incomingOrders) }}
                </h4>

                <p class="mt-2 text-xs text-gray-400">
                    Pesanan yang perlu diproses
                </p>

            </div>

            {{-- SIAP DIAMBIL --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <span class="text-xl">⏰</span>
                </div>

                <p class="text-sm text-gray-500">
                    Siap Diambil
                </p>

                <h4 class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($readyOrders) }}
                </h4>

                <p class="mt-2 text-xs text-gray-400">
                    Pesanan menunggu pickup
                </p>

            </div>

            {{-- TOTAL PENJUALAN --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-700">
                    <span class="text-xl">💰</span>
                </div>

                <p class="text-sm text-gray-500">
                    Total Penjualan
                </p>

                <h4 class="mt-2 text-2xl font-bold text-gray-900">
                    Rp{{ number_format($totalSales, 0, ',', '.') }}
                </h4>

                <p class="mt-2 text-xs text-gray-400">
                    Akumulasi transaksi selesai
                </p>

            </div>

        </div>

    </section>

    {{-- RECENT ORDERS --}}
    <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        <div class="border-b border-gray-100 p-5 lg:p-6">

            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">

                <div>
                    <h3 class="font-bold text-gray-900">
                        Pesanan Terbaru
                    </h3>

                    <p class="mt-1 text-xs text-gray-400">
                        Pantau pesanan yang masuk ke toko Anda.
                    </p>
                </div>

                <a href="{{ route('merchant.orders.index') }}"
                   class="text-sm font-semibold text-green-700 hover:text-green-800">
                    Lihat Semua Pesanan →
                </a>

            </div>

        </div>

        <div class="divide-y divide-gray-100">

            @forelse ($recentOrders as $order)

                @php
                    $statusLabel = match ($order->status) {
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Sudah Dibayar',
                        'ready_for_pickup' => 'Siap Diambil',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($order->status),
                    };

                    $statusColor = match ($order->status) {
                        'pending' => 'bg-amber-100 text-amber-700',
                        'paid' => 'bg-green-100 text-green-700',
                        'ready_for_pickup' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-gray-100 text-gray-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h4 class="font-semibold text-gray-800">
                            {{ $order->order_code }}
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $order->user->name ?? 'Pelanggan' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>

                        <p class="mt-2 text-xs text-gray-500">
                            {{ $order->items->sum('quantity') }} item
                        </p>

                    </div>

                    <div class="flex flex-col items-start gap-2 sm:items-end">

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>

                        <p class="font-bold text-gray-800">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center">

                    <div class="mb-4 text-4xl">
                        🛍️
                    </div>

                    <h4 class="font-semibold text-gray-800">
                        Belum Ada Pesanan
                    </h4>

                    <p class="mt-2 text-sm text-gray-400">
                        Pesanan customer akan muncul di sini.
                    </p>

                </div>

            @endforelse

        </div>

    </section>

@endsection
