<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Sisa.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f3f6ef] text-[#202b24]">

    @include('components.customer-navbar')

    @php
        $payment = $order->payment;
        $merchant = $order->items->first()?->product?->merchant;
        $isPaid = $order->payment_status === 'paid' || $payment?->status === 'paid';
        $isCancelled = $order->status === 'cancelled';
    @endphp

    <main class="mx-auto max-w-5xl px-6 py-10">

        <a href="{{ route('orders.index') }}"
           class="mb-6 inline-flex items-center gap-2 rounded-lg border border-[#174b35]/20 bg-white px-4 py-2.5 text-sm font-semibold text-[#174b35] shadow-sm hover:bg-[#edf7f0]">
            ← Kembali ke Pesanan
        </a>

        <div class="mb-8">
            <h1 class="text-2xl font-bold">Pembayaran Pesanan</h1>
            <p class="mt-1 text-sm text-gray-500">
                Informasi pembayaran dan status transaksi pesananmu.
            </p>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-100 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-100 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-100 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- RINGKASAN PESANAN --}}
        <section class="mb-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-4">
                <div>
                    <p class="text-xs text-gray-400">Kode Pesanan</p>
                    <h2 class="font-bold text-gray-800">{{ $order->order_code }}</h2>
                </div>

                @if ($isPaid)
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Pembayaran Berhasil
                    </span>
                @elseif ($isCancelled)
                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                        Pesanan Dibatalkan
                    </span>
                @else
                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                        Menunggu Pembayaran
                    </span>
                @endif
            </div>

            <div class="space-y-4 py-5">
                @foreach ($order->items as $item)
                    <div class="flex items-center gap-4">

                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-gray-100">
                            @if ($item->product?->photo)
                                <img
                                    src="{{ asset('storage/' . $item->product->photo) }}"
                                    alt="{{ $item->product->name }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-xs text-gray-400">
                                    Foto
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-800">
                                {{ $item->product?->name ?? 'Produk tidak tersedia' }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $item->quantity }} ×
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <p class="shrink-0 text-sm font-semibold">
                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                <span class="font-semibold text-gray-700">Total Pembayaran</span>
                <span class="text-xl font-bold text-[#174b35]">
                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                </span>
            </div>
        </section>

        {{-- PESANAN DIBATALKAN --}}
        @if ($isCancelled)

            <section class="rounded-2xl border border-red-200 bg-red-50 p-6">
                <h2 class="font-bold text-red-800">Pesanan Dibatalkan</h2>
                <p class="mt-2 text-sm text-red-700">
                    Pesanan ini sudah dibatalkan sehingga tidak dapat melakukan pembayaran.
                </p>
            </section>

        {{-- PEMBAYARAN SUDAH BERHASIL --}}
        @elseif ($isPaid)

            <section class="rounded-2xl border border-green-200 bg-white p-6 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="rounded-full bg-green-100 p-3 text-green-700">
                        ✓
                    </div>
                    <div>
                        <h2 class="font-bold text-green-800">Pembayaran Berhasil</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Pembayaran pesananmu telah dikonfirmasi oleh merchant.
                        </p>
                    </div>
                </div>
            </section>

        {{-- BELUM MEMILIH METODE PEMBAYARAN --}}
        @elseif (!$payment)

            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-bold text-gray-800">Pilih Metode Pembayaran</h2>
                <p class="mb-5 mt-1 text-sm text-gray-500">
                    Pilih salah satu metode pembayaran. Metode yang sudah disimpan tidak dapat diubah.
                </p>

                <form action="{{ route('payments.store-method', $order->id) }}" method="POST">
                    @csrf

                    <div class="space-y-4">

                        <label class="flex cursor-pointer items-start gap-4 rounded-xl border border-gray-200 p-5 transition hover:border-[#174b35] hover:bg-[#f5f9f5]">
                            <input
                                type="radio"
                                name="payment_method"
                                value="qris"
                                required
                                class="mt-1 h-4 w-4 accent-[#174b35]"
                                {{ old('payment_method') === 'qris' ? 'checked' : '' }}>

                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800">QRIS</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Bayar menggunakan mobile banking atau e-wallet.
                                </p>
                                <p class="mt-2 text-xs text-green-700">
                                    Kamu perlu mengunggah bukti pembayaran.
                                </p>
                            </div>
                        </label>

                        <label class="flex cursor-pointer items-start gap-4 rounded-xl border border-gray-200 p-5 transition hover:border-[#174b35] hover:bg-[#f5f9f5]">
                            <input
                                type="radio"
                                name="payment_method"
                                value="cod"
                                required
                                class="mt-1 h-4 w-4 accent-[#174b35]"
                                {{ old('payment_method') === 'cod' ? 'checked' : '' }}>

                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800">Bayar di Tempat</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Bayar langsung kepada merchant saat mengambil pesanan.
                                </p>
                            </div>
                        </label>

                    </div>

                    <button
                        type="submit"
                        class="mt-6 w-full rounded-xl bg-[#174b35] px-5 py-3.5 font-semibold text-white transition hover:bg-[#103b29]">
                        Simpan Metode Pembayaran
                    </button>
                </form>
            </section>

        {{-- METODE QRIS SUDAH DIPILIH --}}
        @elseif ($payment->payment_method === 'qris')

            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Pembayaran QRIS</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Scan QRIS merchant berikut untuk membayar pesananmu.
                        </p>
                    </div>

                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                        QRIS
                    </span>
                </div>

                <div class="mt-6 rounded-xl bg-gray-50 p-5 text-center">
                    <p class="mb-4 text-sm font-semibold text-gray-700">
                        QRIS {{ $merchant?->business_name ?? 'Merchant' }}
                    </p>

                    @if ($merchant?->qris_image)
                        <img
                            src="{{ asset('storage/' . $merchant->qris_image) }}"
                            alt="QRIS Merchant"
                            class="mx-auto max-h-80 w-auto rounded-xl border border-gray-200 bg-white p-2">

                        <p class="mt-4 text-lg font-bold text-[#174b35]">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </p>
                    @else
                        <div class="rounded-xl bg-red-50 p-5 text-sm text-red-600">
                            Merchant belum mengunggah gambar QRIS. Silakan hubungi merchant.
                        </div>
                    @endif
                </div>

                @if ($payment->payment_proof)

                    <div class="mt-6 rounded-xl border border-yellow-200 bg-yellow-50 p-5">
                        <h3 class="font-semibold text-yellow-800">
                            Bukti Pembayaran Telah Dikirim
                        </h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            Bukti pembayaran sedang menunggu pemeriksaan merchant. Kamu tidak dapat mengubah bukti yang sudah dikirim.
                        </p>

                        <img
                            src="{{ asset('storage/' . $payment->payment_proof) }}"
                            alt="Bukti Pembayaran"
                            class="mt-4 max-h-64 rounded-xl border border-gray-200">
                    </div>

                @elseif ($merchant?->qris_image)

                    <form
                        action="{{ route('payments.upload-proof', $order->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-6">

                        @csrf

                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Unggah Bukti Pembayaran
                        </label>

                        <input
                            type="file"
                            name="payment_proof"
                            accept="image/jpeg,image/png,image/webp"
                            required
                            class="w-full rounded-xl border border-gray-200 p-3 text-sm">

                        <p class="mt-2 text-xs text-gray-400">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </p>

                        <button
                            type="submit"
                            class="mt-5 w-full rounded-xl bg-[#174b35] px-5 py-3.5 font-semibold text-white hover:bg-[#103b29]">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>

                @endif
            </section>

        {{-- METODE COD SUDAH DIPILIH --}}
        @elseif ($payment->payment_method === 'cod')

            <section class="rounded-2xl border border-green-200 bg-white p-6 shadow-sm">

                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-green-100 p-3 text-[#174b35]">
                        <span class="text-xl">💵</span>
                    </div>

                    <div>
                        <h2 class="font-bold text-gray-800">Bayar di Tempat</h2>
                        <p class="text-sm text-gray-500">
                            Metode pembayaran COD sudah dipilih.
                        </p>
                    </div>
                </div>

                <div class="mt-5 rounded-xl bg-green-50 p-4">
                    <p class="text-sm text-green-800">
                        Silakan lakukan pembayaran sebesar
                        <strong>
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </strong>
                        langsung kepada merchant ketika mengambil makanan.
                    </p>
                </div>

                <p class="mt-4 text-sm text-gray-500">
                    Status pembayaran akan diperbarui setelah merchant mengonfirmasi penerimaan pembayaran.
                </p>
            </section>

        @endif

    </main>

    <footer class="mt-12 border-t border-gray-100 bg-white">
        <div class="flex w-full flex-col items-center justify-between gap-3 px-6 py-6 sm:flex-row lg:px-12 xl:px-16">
            <p class="font-bold text-[#174b35]">Sisa.in</p>
            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Sisa.in. Mengurangi food waste bersama.
            </p>
        </div>
    </footer>

</body>
</html>
