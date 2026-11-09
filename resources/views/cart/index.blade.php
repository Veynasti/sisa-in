<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Sisa.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <nav class="bg-white border-b border-gray-100 px-6 py-5">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('dashboard') }}"
               class="text-2xl font-bold text-green-700">
                Sisa.in
            </a>

            <a href="{{ route('dashboard') }}"
               class="text-sm font-medium text-gray-600 hover:text-green-700">
                Kembali ke Katalog
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Keranjang Belanja
        </h1>

        <p class="text-gray-500 mb-8">
            Periksa kembali produk yang ingin kamu pesan.
        </p>

        @if (session('success'))
            <div class="mb-5 rounded-xl bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl bg-red-100 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-100 p-4 text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if ($cartItems->isEmpty())

            <div class="rounded-2xl bg-white p-12 text-center shadow-sm">
                <div class="text-5xl mb-4">🛒</div>

                <h2 class="text-xl font-bold text-gray-800 mb-2">
                    Keranjangmu masih kosong
                </h2>

                <p class="text-gray-500 mb-6">
                    Yuk, cari makanan surplus dengan harga lebih hemat!
                </p>

                <a href="{{ route('dashboard') }}"
                   class="inline-block rounded-xl bg-green-600 px-6 py-3
                          font-semibold text-white hover:bg-green-700">
                    Mulai Belanja
                </a>
            </div>

        @else

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-4">

                    @foreach ($cartItems as $item)

                        @php
                            $product = $item['product'];
                        @endphp

                        <div class="rounded-2xl bg-white p-5 shadow-sm
                                    flex flex-col sm:flex-row gap-5">

                            <div class="h-28 w-full sm:w-32 shrink-0
                                        rounded-xl bg-gray-100 overflow-hidden">

                                @if ($product->photo)
                                    <img
                                        src="{{ asset('storage/' . $product->photo) }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="h-full flex items-center
                                                justify-center text-gray-400">
                                        Tidak ada foto
                                    </div>
                                @endif

                            </div>

                            <div class="flex-1">

                                <p class="text-sm text-gray-500">
                                    {{ $product->merchant->business_name ?? 'Merchant' }}
                                </p>

                                <h3 class="font-bold text-gray-800 text-lg">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-green-700 font-bold mt-1">
                                    Rp{{ number_format($product->surplus_price, 0, ',', '.') }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Stok tersedia: {{ $product->stock }}
                                </p>

                                <div class="flex flex-wrap items-center
                                            justify-between gap-4 mt-4">

                                    <form
                                        action="{{ route('cart.update', $product->id) }}"
                                        method="POST"
                                        class="flex items-center gap-2"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            max="{{ $product->stock }}"
                                            class="w-20 rounded-lg border border-gray-300
                                                   px-3 py-2 text-center"
                                        >

                                        <button
                                            type="submit"
                                            class="text-sm font-semibold text-green-700
                                                   hover:text-green-900"
                                        >
                                            Perbarui
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('cart.remove', $product->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-sm font-semibold text-red-500
                                                   hover:text-red-700"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                                <p class="text-sm text-gray-600 mt-3">
                                    Subtotal:
                                    <span class="font-bold text-gray-800">
                                        Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </span>
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="h-fit rounded-2xl bg-white p-6 shadow-sm">

                    <h2 class="text-lg font-bold text-gray-800 mb-5">
                        Ringkasan Belanja
                    </h2>

                    <div class="flex justify-between text-sm mb-4">
                        <span class="text-gray-500">
                            Total Produk
                        </span>

                        <span class="font-semibold">
                            {{ $cartItems->sum('quantity') }} item
                        </span>
                    </div>

                    <div class="border-t border-gray-100 pt-4
                                flex justify-between items-center">

                        <span class="font-semibold text-gray-700">
                            Total Harga
                        </span>

                        <span class="text-xl font-bold text-green-700">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>

                    </div>

                    <button
                        type="button"
                        disabled
                        class="w-full mt-6 rounded-xl bg-gray-300
                               px-5 py-3 font-semibold text-gray-500
                               cursor-not-allowed"
                    >
                        Checkout Segera Hadir
                    </button>

                    <p class="text-xs text-gray-400 text-center mt-3">
                        Fitur checkout akan dibuat pada tahap berikutnya.
                    </p>

                </div>

            </div>

        @endif

    </main>

</body>
</html>
