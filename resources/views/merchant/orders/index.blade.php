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
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <h3 class="mt-2 text-3xl font-bold text-gray-800">
                {{ $totalOrders }}
            </h3>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Menunggu Konfirmasi</p>
            <h3 class="mt-2 text-3xl font-bold text-amber-600">
                {{ $waitingPayment }}
            </h3>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Pembayaran Berhasil</p>
            <h3 class="mt-2 text-3xl font-bold text-green-600">
                {{ $paidOrders }}
            </h3>
        </div>

    </div>

    {{-- DAFTAR PESANAN --}}
    <div class="space-y-4">

        <div>
            <h2 class="text-lg font-bold text-gray-800">Daftar Pesanan</h2>
            <p class="mt-1 text-sm text-gray-500">
                Periksa pesanan dan pembayaran yang masuk ke tokomu.
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
                            && $payment->payment_proof
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

                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                            {{ $order->status === 'cancelled'
                                ? 'bg-red-100 text-red-700'
                                : ($order->payment_status === 'paid'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-amber-100 text-amber-700') }}">
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

                    {{-- PRODUK --}}
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

                            <p class="text-sm text-amber-600">
                                Pelanggan belum memilih metode pembayaran.
                            </p>

                        @elseif ($paymentMethod === 'qris')

                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-sm text-gray-500">Metode</span>
                                <span class="text-sm font-semibold text-gray-800">QRIS</span>
                            </div>

                            @if ($payment->payment_proof)

                                <div class="space-y-3">

                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Bukti Pembayaran</span>

                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Sudah Diunggah
                                        </span>
                                    </div>

                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="inline-block">

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

                                <p class="text-sm text-amber-600">
                                    Pelanggan belum mengunggah bukti pembayaran QRIS.
                                </p>

                            @endif

                        @elseif ($paymentMethod === 'cod')

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Metode</span>
                                <span class="text-sm font-semibold text-gray-800">
                                    Bayar di Tempat (COD)
                                </span>
                            </div>

                            <p class="mt-3 text-sm text-gray-500">
                                Konfirmasikan pembayaran setelah pelanggan membayar secara langsung saat mengambil pesanan.
                            </p>

                        @endif

                        @if ($payment && $payment->status === 'paid')

                            <div class="mt-4 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                                Pembayaran telah dikonfirmasi pada
                                {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}.
                            </div>

                        @elseif ($canConfirm)

                            <form
                                action="{{ route('merchant.orders.confirm-payment', $order->id) }}"
                                method="POST"
                                class="mt-4"
                                onsubmit="return confirm('Apakah kamu yakin ingin mengonfirmasi pembayaran pesanan ini?')"
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
                                Menunggu pelanggan mengunggah bukti pembayaran QRIS.
                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50">
                    <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 3h2l2.2 11.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 7H6" />
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
