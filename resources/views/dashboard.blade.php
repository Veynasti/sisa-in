<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f3f6ef] text-[#202b24]">

    {{-- NAVBAR --}}
    @include('components.customer-navbar')

    {{-- HERO SECTION --}}
    <section class="relative min-h-97.5 lg:min-h-107.5 overflow-hidden flex items-center">

        <img
            src="{{ asset('images/bg.jpg') }}"
            alt="Makanan surplus Sisa.in"
            class="absolute inset-0 w-full h-full object-cover object-center"
        >

        <div class="absolute inset-0 bg-linear-to-r from-[#102f23]/90 via-[#174b35]/70 to-[#174b35]/30"></div>

        <div class="relative z-10 w-full px-6 lg:px-12 xl:px-16 py-14">

            <div class="max-w-2xl">

                <p class="text-sm font-semibold tracking-widest text-green-200 mb-4 uppercase">
                    Selamat datang di Sisa.in
                </p>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight text-white">
                    Makan Enak,<br>
                    <span class="text-[#b9e5a9]">
                        Lebih Hemat!
                    </span>
                </h1>

                <p class="text-green-50 mt-5 max-w-lg leading-relaxed">
                    Temukan makanan surplus berkualitas dengan harga lebih terjangkau
                    dan bantu kurangi food waste bersama Sisa.in.
                </p>

                {{-- SEARCH --}}
                <form
                    action="{{ route('dashboard') }}"
                    method="GET"
                    class="mt-7 max-w-lg relative">

                    @if(request('category'))
                        <input
                            type="hidden"
                            name="category"
                            value="{{ request('category') }}"
                        >
                    @endif

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari makanan favoritmu..."
                        class="w-full rounded-xl bg-white text-gray-800 placeholder:text-gray-400 px-12 py-4 text-sm shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300"
                    >

                    <svg
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round">

                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>

                    </svg>

                </form>

            </div>
        </div>
    </section>


    {{-- MAIN CONTENT --}}
    <main class="w-full px-6 lg:px-12 xl:px-16 py-8">

        {{-- CATEGORIES --}}
        <section id="kategori" class="mb-9">

            <div class="flex justify-between items-center mb-4">

                <div>
                    <h2 class="text-xl font-bold">
                        Kategori
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Pilih kategori yang kamu suka
                    </p>
                </div>

                <a href="#produk"
                    class="text-sm font-semibold text-[#174b35] hover:underline">
                    Lihat semua →
                </a>

            </div>

            <div class="flex flex-wrap gap-3">

                {{-- SEMUA KATEGORI --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="px-6 py-3 rounded-full text-sm font-medium shadow-sm transition
                    {{ !request('category')
                        ? 'bg-[#174b35] text-white'
                        : 'bg-white border border-gray-200 hover:border-[#174b35]' }}">

                    Semua

                </a>

                {{-- KATEGORI DARI DATABASE --}}
                @foreach ($categories as $category)

                    <a
                        href="{{ route('dashboard', array_merge(request()->query(), ['category' => $category->id])) }}"
                        class="px-6 py-3 rounded-full text-sm font-medium shadow-sm transition
                        {{ request('category') == $category->id
                            ? 'bg-[#174b35] text-white'
                            : 'bg-white border border-gray-200 hover:border-[#174b35]' }}">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>
        </section>


        {{-- PRODUCTS --}}
        <section id="produk">

            <div class="flex justify-between items-center mb-5">

                <div>
                    <h2 class="text-xl font-bold">
                        Surplus Food Terdekat
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Pilihan makanan hemat untukmu
                    </p>
                </div>

                <span class="text-sm text-gray-500">
                    {{ $products->count() }} produk tersedia
                </span>

            </div>


            {{-- PRODUCT LIST --}}
            @if ($products->count() > 0)

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    @foreach ($products as $product)

                        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">

                            {{-- PRODUCT IMAGE --}}
                            <div class="h-40 overflow-hidden bg-gray-100">

                                @if ($product->photo)

                                    <img
                                        src="{{ asset('storage/' . $product->photo) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.style.display='none'">

                                @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                        Tidak ada foto
                                    </div>

                                @endif

                            </div>


                            {{-- PRODUCT INFORMATION --}}
                            <div class="p-4">

                                <p class="text-xs text-gray-500">
                                    {{ $product->merchant->business_name }}
                                </p>

                                <h3 class="font-bold mt-1">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $product->category->name ?? 'Tanpa kategori' }}
                                </p>


                                {{-- PRODUCT PRICE --}}
                                <div class="flex items-center gap-2 mt-3">

                                    <p class="font-bold text-[#187345] text-lg">
                                        Rp{{ number_format($product->surplus_price, 0, ',', '.') }}
                                    </p>

                                    <p class="text-xs text-gray-400 line-through">
                                        Rp{{ number_format($product->normal_price, 0, ',', '.') }}
                                    </p>

                                </div>


                                {{-- STOCK --}}
                                <p class="text-xs text-gray-500 mt-3">
                                    Stok tersedia: {{ $product->stock }}
                                </p>


                                {{-- PICKUP TIME --}}
                                <p class="text-xs text-gray-500 mt-1">
                                    Pickup:

                                    {{ \Carbon\Carbon::parse($product->pickup_start)->format('H:i') }}

                                    -

                                    {{ \Carbon\Carbon::parse($product->pickup_end)->format('H:i') }}
                                </p>


                                {{-- ADD TO CART --}}
                                <a
                                    href="{{ route('orders.create', $product->id) }}"
                                    class="block w-full rounded-xl bg-green-600 px-4 py-3
                                        text-center font-semibold text-white
                                        transition hover:bg-green-700
                                        {{ $product->stock < 1 ? 'pointer-events-none opacity-50' : '' }}"
                                >
                                    @if ($product->stock > 0)
                                        Pesan Sekarang
                                    @else
                                        Stok Habis
                                    @endif
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                {{-- EMPTY PRODUCT --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-10 text-center">

                    <div class="text-4xl mb-3">
                        🍽️
                    </div>

                    <h3 class="font-bold text-lg text-gray-700">
                        Produk belum tersedia
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Belum ada produk yang sesuai dengan pencarian atau kategori kamu.
                    </p>

                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-block mt-5 px-6 py-2.5 rounded-full bg-[#174b35] text-white text-sm font-semibold hover:bg-[#103b29] transition">

                        Lihat Semua Produk

                    </a>

                </div>

            @endif

        </section>


        {{-- PICKUP INFORMATION --}}
        <section id="pesanan" class="mt-8">

            <div class="bg-[#dcebd5] border border-[#c9dfc1] rounded-2xl px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                <div>
                    <h3 class="font-bold text-[#174b35]">
                        Pesan makanan, ambil langsung!
                    </h3>

                    <p class="text-sm text-[#45664e] mt-1">
                        Dukung gerakan mengurangi food waste bersama Sisa.in.
                    </p>
                </div>

                <span class="text-sm font-semibold text-[#174b35]">
                    Pickup di merchant
                </span>

            </div>

        </section>

    </main>


    {{-- FOOTER --}}
    <footer class="mt-12 bg-white border-t border-gray-100">

        <div class="w-full px-6 lg:px-12 xl:px-16 py-6 flex flex-col sm:flex-row justify-between items-center gap-3">

            <p class="font-bold text-[#174b35]">
                Sisa.in
            </p>

            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Sisa.in. Mengurangi food waste bersama.
            </p>

        </div>

    </footer>

</body>
</html>
