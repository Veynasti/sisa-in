
@extends('layouts.merchant')

@section('title', 'Dashboard Merchant - Sisa.in')

@section('page-title', 'Dashboard')

@section('page-description', 'Kelola aktivitas toko Anda.')

@section('content')

    {{-- Welcome --}}
    <section class="mb-8">
        <p class="text-sm font-medium text-green-700 mb-2">
            MERCHANT CENTER
        </p>

        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
            Selamat datang, {{ auth()->user()->name }}!
        </h2>

        <p class="text-sm text-gray-500 mt-2">
            Pantau dan kelola aktivitas toko Anda melalui halaman ini.
        </p>
    </section>

    {{-- Store Banner --}}
    <section class="bg-linear-to-r from-[#174b35] to-[#286c4b] rounded-2xl p-7 lg:p-9 text-white mb-8">
        <p class="text-xs font-semibold tracking-widest text-green-200 uppercase mb-3">
            Toko Anda
        </p>

        <h3 class="text-2xl md:text-3xl font-bold">
            {{ auth()->user()->merchant?->business_name ?? 'Nama Toko' }}
        </h3>

        <p class="text-sm text-green-100 mt-3 max-w-xl leading-relaxed">
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

            <p class="text-sm text-gray-400 mt-1">
                Informasi aktivitas toko Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-700 flex items-center justify-center mb-4">
                    <span class="text-xl">📦</span>
                </div>
                <p class="text-sm text-gray-500">Produk Aktif</p>
                <h4 class="text-2xl font-bold mt-2">—</h4>
                <p class="text-xs text-gray-400 mt-2">Jumlah produk tersedia</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mb-4">
                    <span class="text-xl">🛍️</span>
                </div>
                <p class="text-sm text-gray-500">Pesanan Masuk</p>
                <h4 class="text-2xl font-bold mt-2">—</h4>
                <p class="text-xs text-gray-400 mt-2">Pesanan yang perlu diproses</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                    <span class="text-xl">⏰</span>
                </div>
                <p class="text-sm text-gray-500">Siap Diambil</p>
                <h4 class="text-2xl font-bold mt-2">—</h4>
                <p class="text-xs text-gray-400 mt-2">Pesanan menunggu pickup</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center mb-4">
                    <span class="text-xl">💰</span>
                </div>
                <p class="text-sm text-gray-500">Total Penjualan</p>
                <h4 class="text-2xl font-bold mt-2">—</h4>
                <p class="text-xs text-gray-400 mt-2">Akumulasi transaksi selesai</p>
            </div>

        </div>
    </section>

    {{-- RECENT ORDERS --}}
    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="p-5 lg:p-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">
                Pesanan Terbaru
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Pantau pesanan yang masuk ke toko Anda.
            </p>
        </div>

        <div class="p-10 text-center">
            <div class="text-4xl mb-4">🛍️</div>

            <h4 class="font-semibold text-gray-800">
                Belum ada pesanan
            </h4>

            <p class="text-sm text-gray-400 mt-2">
                Pesanan customer akan muncul di sini.
            </p>
        </div>

    </section>

@endsection
