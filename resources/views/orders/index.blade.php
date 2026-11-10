<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f3f6ef] text-[#202b24]">

    @include('components.customer-navbar')

    <main class="min-h-screen px-4 py-10 sm:px-6">
        <div class="mx-auto max-w-6xl">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#263b2d] sm:text-3xl">
                    Pesanan Saya
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Pantau pesanan, pembayaran, dan proses pengambilan makananmu.
                </p>
            </div>

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- DAFTAR PESANAN --}}
            @forelse ($orders as $order)

                @php
                    $payment = $order->payment;

                    $isCancelled = $order->status === 'cancelled';

                    $isPaid = $order->payment_status === 'paid'
                        || in_array($order->status, [
                            'paid',
                            'ready_for_pickup',
                            'completed'
                        ]);

                    $paymentMethod = $payment->payment_method ?? null;
                    $paymentProof = $payment->payment_proof ?? null;

                    $hasPayment = $payment !== null;
                    $hasProof = !empty($paymentProof);

                    // STATUS PESANAN
                    $statusLabel = match ($order->status) {
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Pembayaran Berhasil',
                        'ready_for_pickup' => 'Siap Diambil',
                        'completed' => 'Pesanan Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst(str_replace('_', ' ', $order->status)),
                    };

                    $statusClass = match ($order->status) {
                        'pending' => 'bg-amber-100 text-amber-700',
                        'paid' => 'bg-green-100 text-green-700',
                        'ready_for_pickup' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-emerald-100 text-emerald-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700',
                    };

                    // STATUS PEMBAYARAN
                    if ($isCancelled) {
                        $paymentStatusLabel = 'Pesanan dibatalkan';
                        $paymentStatusClass = 'text-red-600';
                    } elseif ($isPaid) {
                        $paymentStatusLabel = 'Pembayaran berhasil';
                        $paymentStatusClass = 'text-green-600';
                    } elseif ($paymentMethod === 'qris' && $hasProof) {
                        $paymentStatusLabel = 'Menunggu konfirmasi pembayaran dari merchant';
                        $paymentStatusClass = 'text-blue-600';
                    } elseif ($paymentMethod === 'qris') {
                        $paymentStatusLabel = 'Menunggu unggahan bukti pembayaran';
                        $paymentStatusClass = 'text-amber-600';
                    } elseif ($paymentMethod === 'cod') {
                        $paymentStatusLabel = 'Bayar di tempat saat pengambilan';
                        $paymentStatusClass = 'text-amber-600';
                    } else {
                        $paymentStatusLabel = 'Belum memilih metode pembayaran';
                        $paymentStatusClass = 'text-amber-600';
                    }

                    // TOMBOL PEMBAYARAN
                    $canChoosePayment = !$isCancelled && !$isPaid && !$hasPayment;

                    $canContinueQris = !$isCancelled
                        && !$isPaid
                        && $paymentMethod === 'qris'
                        && !$hasProof;

                    // TOMBOL PEMBATALAN
                    $canCancel = $order->status === 'pending'
                        && !$isPaid
                        && !$hasProof;
                @endphp

                <div class="mb-6 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                    {{-- HEADER PESANAN --}}
                    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <p class="text-xs text-gray-400">
                                Kode Pesanan
                            </p>

                            <h3 class="mt-1 font-bold text-gray-800">
                                {{ $order->order_code }}
                            </h3>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <span class="w-fit rounded-full px-4 py-2 text-xs font-semibold {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>

                    </div>

                    {{-- DETAIL PRODUK --}}
                    <div class="space-y-4 p-5">

                        @foreach ($order->items as $item)

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                                {{-- FOTO PRODUK --}}
                                <div class="h-24 w-full overflow-hidden rounded-xl bg-gray-100 sm:h-24 sm:w-28">
                                    @if ($item->product && $item->product->photo)
                                        <img
                                            src="{{ asset('storage/' . $item->product->photo) }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-full items-center justify-center text-xs text-gray-400">
                                            Tidak ada foto
                                        </div>
                                    @endif
                                </div>

                                {{-- INFORMASI PRODUK --}}
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800">
                                        {{ $item->product->name ?? 'Produk tidak tersedia' }}
                                    </h4>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $item->product->merchant->business_name ?? 'Merchant' }}
                                    </p>

                                    <p class="mt-2 text-sm text-gray-500">
                                        {{ $item->quantity }} ×
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- SUBTOTAL --}}
                                <div class="text-left sm:text-right">
                                    <p class="text-xs text-gray-400">
                                        Subtotal
                                    </p>

                                    <p class="mt-1 font-bold text-[#39734a]">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- INFORMASI PEMBAYARAN DAN PENGAMBILAN --}}
                    <div class="border-t border-gray-100 bg-gray-50/70 p-5">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            {{-- KODE PENGAMBILAN --}}
                            <div>
                                @if ($isPaid && !$isCancelled)
                                    <p class="text-xs text-gray-400">
                                        Kode Pengambilan
                                    </p>

                                    <p class="mt-1 text-lg font-bold tracking-wider text-[#39734a]">
                                        {{ $order->pickup_code }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Tunjukkan kode ini kepada merchant saat mengambil pesanan.
                                    </p>
                                @else
                                    <p class="text-sm font-medium text-gray-500">
                                        Kode pengambilan akan digunakan setelah pembayaran dikonfirmasi.
                                    </p>
                                @endif
                            </div>

                            {{-- TOTAL --}}
                            <div class="sm:text-right">
                                <p class="text-xs text-gray-400">
                                    Total Pembayaran
                                </p>

                                <p class="mt-1 text-xl font-bold text-gray-800">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>

                        {{-- DETAIL METODE PEMBAYARAN --}}
                        <div class="mt-5 border-t border-gray-200 pt-4">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div>
                                    <p class="text-xs text-gray-400">
                                        Metode Pembayaran
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-800">
                                        @if ($paymentMethod === 'qris')
                                            QRIS
                                        @elseif ($paymentMethod === 'cod')
                                            Bayar di Tempat (COD)
                                        @else
                                            Belum dipilih
                                        @endif
                                    </p>
                                </div>

                                <div class="sm:text-right">
                                    <p class="text-xs text-gray-400">
                                        Status Pembayaran
                                    </p>

                                    <p class="mt-1 text-sm font-semibold {{ $paymentStatusClass }}">
                                        {{ $paymentStatusLabel }}
                                    </p>
                                </div>

                            </div>

                            {{-- BUKTI PEMBAYARAN QRIS --}}
                            @if ($paymentMethod === 'qris' && $hasProof)
                                <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
                                    <p class="text-sm font-semibold text-blue-800">
                                        Bukti pembayaran sudah diunggah
                                    </p>

                                    <p class="mt-1 text-xs text-blue-600">
                                        Silakan tunggu merchant memeriksa bukti pembayaranmu.
                                    </p>

                                    <a
                                        href="{{ asset('storage/' . $paymentProof) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-3 inline-flex text-sm font-semibold text-blue-700 underline"
                                    >
                                        Lihat Bukti Pembayaran
                                    </a>
                                </div>
                            @endif

                            {{-- INFORMASI COD --}}
                            @if ($paymentMethod === 'cod' && !$isPaid && !$isCancelled)
                                <div class="mt-4 rounded-xl border border-amber-100 bg-amber-50 p-4">
                                    <p class="text-sm font-semibold text-amber-800">
                                        Pembayaran di tempat
                                    </p>

                                    <p class="mt-1 text-xs leading-relaxed text-amber-700">
                                        Siapkan pembayaran sebesar
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}.
                                        Pembayaran dilakukan langsung kepada merchant saat mengambil pesanan.
                                    </p>
                                </div>
                            @endif

                            {{-- INFORMASI STATUS PESANAN --}}
                            @if ($order->status === 'paid')
                                <div class="mt-4 rounded-xl border border-green-100 bg-green-50 p-4">
                                    <p class="text-sm font-semibold text-green-800">
                                        Pembayaran telah dikonfirmasi!
                                    </p>

                                    <p class="mt-1 text-xs text-green-700">
                                        Merchant sedang menyiapkan pesananmu.
                                    </p>
                                </div>

                            @elseif ($order->status === 'ready_for_pickup')
                                <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
                                    <p class="text-sm font-semibold text-blue-800">
                                        Pesanan siap diambil!
                                    </p>

                                    <p class="mt-1 text-xs text-blue-700">
                                        Silakan datang ke merchant dan tunjukkan kode pengambilan.
                                    </p>
                                </div>

                            @elseif ($order->status === 'completed')
                                <div class="mt-4 rounded-xl border border-green-100 bg-green-50 p-4">
                                    <p class="text-sm font-semibold text-green-800">
                                        Pesanan selesai.
                                    </p>

                                    <p class="mt-1 text-xs text-green-700">
                                        Terima kasih sudah menggunakan Sisa.in. Selamat menikmati makananmu!
                                    </p>
                                </div>

                            @elseif ($isCancelled)
                                <div class="mt-4 rounded-xl border border-red-100 bg-red-50 p-4">
                                    <p class="text-sm font-semibold text-red-800">
                                        Pesanan dibatalkan.
                                    </p>

                                    <p class="mt-1 text-xs text-red-700">
                                        Pesanan ini sudah tidak dapat dilanjutkan.
                                    </p>
                                </div>
                            @endif

                            {{-- TOMBOL TINDAKAN --}}
                            @if ($canChoosePayment || $canContinueQris || $canCancel || $isPaid)
                                <div class="mt-5 flex flex-col gap-3 border-t border-gray-200 pt-4 sm:flex-row sm:justify-end">

                                    {{-- PILIH METODE PEMBAYARAN --}}
                                    @if ($canChoosePayment)
                                        <a
                                            href="{{ route('payments.method', $order->id) }}"
                                            class="inline-flex items-center justify-center rounded-xl bg-[#39734a] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#2d5d3b]"
                                        >
                                            Pilih Metode Pembayaran
                                        </a>
                                    @endif

                                    {{-- LANJUTKAN PEMBAYARAN QRIS --}}
                                    @if ($canContinueQris)
                                        <a
                                            href="{{ route('payments.method', $order->id) }}"
                                            class="inline-flex items-center justify-center rounded-xl bg-[#39734a] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#2d5d3b]"
                                        >
                                            Lanjutkan Pembayaran QRIS
                                        </a>
                                    @endif

                                    {{-- BATALKAN PESANAN --}}
                                    @if ($canCancel)
                                        <form
                                            action="{{ route('orders.cancel', $order->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini? Stok produk akan dikembalikan.');"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-xl border border-red-200 bg-white px-6 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                            >
                                                Batalkan Pesanan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- PEMBAYARAN BERHASIL --}}
                                    @if ($isPaid)
                                        <span class="inline-flex items-center justify-center rounded-xl bg-green-100 px-5 py-3 text-sm font-semibold text-green-700">
                                            Pembayaran Berhasil
                                        </span>
                                    @endif

                                </div>
                            @endif

                            {{-- MENUNGGU KONFIRMASI QRIS --}}
                            @if ($paymentMethod === 'qris' && $hasProof && !$isCancelled && !$isPaid)
                                <div class="mt-5 flex justify-end border-t border-gray-200 pt-4">
                                    <span class="inline-flex items-center justify-center rounded-xl bg-blue-100 px-5 py-3 text-sm font-semibold text-blue-700">
                                        Menunggu Konfirmasi Merchant
                                    </span>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            @empty

                {{-- BELUM ADA PESANAN --}}
                <div class="rounded-2xl border border-gray-100 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-50">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 3h2l2.2 11.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 7H6" />
                            <circle cx="10" cy="20" r="1" />
                            <circle cx="18" cy="20" r="1" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-gray-800">
                        Belum Ada Pesanan
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Kamu belum memiliki pesanan. Yuk, cari makanan surplus favoritmu!
                    </p>

                    <a
                        href="{{ route('dashboard') }}"
                        class="mt-6 inline-flex rounded-xl bg-[#39734a] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#2d5d3b]"
                    >
                        Jelajahi Makanan
                    </a>

                </div>

            @endforelse

        </div>
    </main>

</body>
</html>
