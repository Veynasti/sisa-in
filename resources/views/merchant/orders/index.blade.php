@extends('layouts.merchant')

@section('title', 'Pesanan Masuk - Sisa.in')
@section('page-title', 'Pesanan Masuk')
@section('page-description', 'Kelola pesanan pelanggan dan konfirmasi pembayaran.')

@section('content')

<div class="space-y-6">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RINGKASAN --}}
    @php
        $totalOrders = $orders->count();

        $waitingPayment = $orders->filter(function ($order) {
            return $order->payment
                && $order->payment->status === 'pending';
        })->count();

        $paidOrders = $orders->filter(function ($order) {
            return $order->payment_status === 'paid';
        })->count();
    @endphp

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-xl">
                🛍️
            </div>
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <h3 class="mt-2 text-3xl font-bold text-gray-800">
                {{ $totalOrders }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Seluruh pesanan toko</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-xl">
                ⏳
            </div>
            <p class="text-sm text-gray-500">Menunggu Konfirmasi</p>
            <h3 class="mt-2 text-3xl font-bold text-amber-600">
                {{ $waitingPayment }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Pembayaran belum dikonfirmasi</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-xl">
                ✅
            </div>
            <p class="text-sm text-gray-500">Pembayaran Berhasil</p>
            <h3 class="mt-2 text-3xl font-bold text-green-600">
                {{ $paidOrders }}
            </h3>
            <p class="mt-1 text-xs text-gray-400">Pesanan sudah dibayar</p>
        </div>

    </div>

    {{-- DAFTAR PESANAN --}}
    <div class="space-y-4">

        <div>
            <h2 class="text-lg font-bold text-gray-800">
                Daftar Pesanan
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Periksa pesanan, bukti pembayaran, dan proses pengambilan makanan.
            </p>
        </div>

        @forelse ($orders as $order)

            @php
                $payment = $order->payment;
                $paymentMethod = $payment?->payment_method;

                $canConfirm = $payment
                    && $payment->status === 'pending'
                    && $order->payment_status !== 'paid'
                    && $order->status !== 'cancelled'
                    && (
                        $paymentMethod === 'cod'
                        || (
                            $paymentMethod === 'qris'
                            && !empty($payment->payment_proof)
                        )
                    );

                $statusLabel = match ($order->status) {
                    'pending' => 'Menunggu Pembayaran',
                    'paid' => 'Sudah Dibayar',
                    'ready_for_pickup' => 'Siap Diambil',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => ucfirst($order->status),
                };

                $statusClass = match ($order->status) {
                    'pending' => 'bg-amber-100 text-amber-700',
                    'paid' => 'bg-green-100 text-green-700',
                    'ready_for_pickup' => 'bg-blue-100 text-blue-700',
                    'completed' => 'bg-gray-100 text-gray-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp

            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                {{-- HEADER PESANAN --}}
                <div class="flex flex-col gap-3 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Kode Pesanan
                        </p>

                        <h3 class="mt-1 font-bold text-gray-800">
                            {{ $order->order_code }}
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                            {{ $paymentMethod ? strtoupper($paymentMethod) : 'Belum Memilih Pembayaran' }}
                        </span>

                    </div>

                </div>

                <div class="space-y-5 p-5">

                    {{-- INFORMASI PELANGGAN --}}
                    <div>
                        <h4 class="mb-2 text-sm font-bold text-gray-700">
                            Informasi Pelanggan
                        </h4>

                        <p class="text-sm text-gray-600">
                            {{ $order->user->name ?? 'Pelanggan' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Kode pengambilan: {{ $order->pickup_code }}
                        </p>
                    </div>

                    {{-- DETAIL PRODUK --}}
                    <div>
                        <h4 class="mb-3 text-sm font-bold text-gray-700">
                            Detail Produk
                        </h4>

                        <div class="space-y-3">

                            @foreach ($order->items as $item)

                                <div class="flex items-center justify-between gap-4 rounded-xl bg-gray-50 p-3">

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $item->product->name ?? 'Produk' }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $item->quantity }} ×
                                            Rp{{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <p class="whitespace-nowrap text-sm font-semibold text-gray-700">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>

                                </div>

                            @endforeach

                        </div>

                        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="text-sm font-semibold text-gray-600">
                                Total Pembayaran
                            </span>

                            <span class="text-lg font-bold text-green-700">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- INFORMASI PEMBAYARAN --}}
                    <div class="rounded-xl border border-gray-100 p-4">

                        <h4 class="mb-3 text-sm font-bold text-gray-700">
                            Informasi Pembayaran
                        </h4>

                        @if (!$payment)

                            <div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                Pelanggan belum memilih metode pembayaran.
                            </div>

                        @elseif ($paymentMethod === 'qris')

                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-sm text-gray-500">Metode Pembayaran</span>
                                <span class="text-sm font-semibold text-gray-800">QRIS</span>
                            </div>

                            @if ($payment->payment_proof)

                                <div class="space-y-3">

                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <span class="text-sm text-gray-500">
                                            Bukti Pembayaran
                                        </span>

                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Sudah Diunggah
                                        </span>
                                    </div>

                                    <a
                                        href="{{ asset('storage/' . $payment->payment_proof) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-block"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $payment->payment_proof) }}"
                                            alt="Bukti pembayaran QRIS"
                                            class="max-h-72 w-auto rounded-xl border border-gray-200 object-contain"
                                        >
                                    </a>

                                    <p class="text-xs text-gray-400">
                                        Klik gambar untuk melihat bukti pembayaran dengan ukuran lebih besar.
                                    </p>

                                </div>

                            @else

                                <div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                    Pelanggan belum mengunggah bukti pembayaran QRIS.
                                </div>

                            @endif

                        @elseif ($paymentMethod === 'cod')

                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm text-gray-500">
                                    Metode Pembayaran
                                </span>

                                <span class="text-sm font-semibold text-gray-800">
                                    Bayar di Tempat (COD)
                                </span>
                            </div>

                            <p class="mt-3 text-sm text-gray-500">
                                Pastikan pelanggan sudah membayar secara langsung saat mengambil pesanan sebelum mengonfirmasi pembayaran.
                            </p>

                        @endif

                        {{-- STATUS PEMBAYARAN --}}
                        @if ($payment && $payment->status === 'paid')

                            <div class="mt-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                                <p class="font-semibold">
                                    Pembayaran telah dikonfirmasi.
                                </p>

                                <p class="mt-1 text-xs">
                                    {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>

                        @elseif ($canConfirm)

                            <form
                                action="{{ route('merchant.orders.confirm-payment', $order->id) }}"
                                method="POST"
                                class="mt-4"
                                onsubmit="return confirm('Pastikan pembayaran benar-benar sudah diterima. Lanjutkan konfirmasi?')"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700"
                                >
                                    Konfirmasi Pembayaran
                                </button>
                            </form>

                        @elseif ($payment && $payment->status === 'pending' && $order->status !== 'cancelled')

                            <div class="mt-4 rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                @if ($paymentMethod === 'qris')
                                    Menunggu pelanggan mengunggah bukti pembayaran QRIS.
                                @else
                                    Menunggu konfirmasi pembayaran dari merchant.
                                @endif
                            </div>

                        @endif

                    </div>

                    {{-- PENGELOLAAN STATUS PESANAN --}}
                    @if ($order->status === 'paid')

                        <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">

                            <p class="text-sm font-semibold text-blue-800">
                                Pembayaran Sudah Dikonfirmasi
                            </p>

                            <p class="mt-1 text-sm text-blue-700">
                                Silakan siapkan makanan pesanan sebelum menandainya sebagai siap diambil.
                            </p>

                            <form
                                action="{{ route('merchant.orders.mark-ready', $order->id) }}"
                                method="POST"
                                class="mt-4"
                                onsubmit="return confirm('Apakah pesanan ini sudah siap diambil customer?')"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                                >
                                    Tandai Siap Diambil
                                </button>
                            </form>

                        </div>

                    @elseif ($order->status === 'ready_for_pickup')

                        <div class="rounded-xl border border-orange-100 bg-orange-50 p-4">

                            <p class="text-sm font-semibold text-orange-800">
                                Pesanan Siap Diambil
                            </p>

                            <p class="mt-1 text-sm text-orange-700">
                                Pastikan customer sudah mengambil makanan dan menunjukkan kode pengambilan.
                            </p>

                            <div class="mt-3 rounded-lg bg-white p-4 text-center">
                                <p class="text-xs text-gray-500">
                                    Kode Pengambilan
                                </p>

                                <p class="mt-1 text-2xl font-bold tracking-widest text-gray-800">
                                    {{ $order->pickup_code }}
                                </p>
                            </div>

                            <form
                                action="{{ route('merchant.orders.complete', $order->id) }}"
                                method="POST"
                                class="mt-4"
                                onsubmit="return confirm('Apakah customer sudah mengambil pesanannya?')"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700"
                                >
                                    Selesaikan Pesanan
                                </button>
                            </form>

                        </div>

                    @elseif ($order->status === 'completed')

                        <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-4">
                            <p class="text-sm font-semibold text-green-700">
                                Pesanan Selesai
                            </p>

                            <p class="mt-1 text-xs text-green-600">
                                Pesanan ini telah diselesaikan.
                            </p>
                        </div>

                    @elseif ($order->status === 'cancelled')

                        <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-4">
                            <p class="text-sm font-semibold text-red-700">
                                Pesanan Dibatalkan
                            </p>

                            <p class="mt-1 text-xs text-red-600">
                                Pesanan ini tidak dapat diproses kembali.
                            </p>
                        </div>

                    @endif

                </div>

            </div>

        @empty

            {{-- BELUM ADA PESANAN --}}
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50">
                    <svg
                        class="h-7 w-7 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M3 3h2l2.2 11.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 7H6"
                        />
                        <circle cx="10" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>
                </div>

                <h3 class="mt-4 font-bold text-gray-800">
                    Belum Ada Pesanan
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Pesanan pelanggan akan muncul di halaman ini.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection
