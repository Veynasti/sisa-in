
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sisa.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f3f6ef] text-[#202b24]">

    <!-- NAVBAR -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="w-full px-6 lg:px-12 xl:px-16">
            <div class="h-20 flex items-center justify-between gap-6">

                <a href="/dashboard" class="text-2xl font-bold text-[#174b35]">
                    Sisa.in
                </a>

                <nav class="hidden md:flex items-center gap-8 text-sm">
                    <a href="/dashboard" class="font-semibold text-[#174b35]">Beranda</a>
                    <a href="#produk" class="text-gray-500 hover:text-[#174b35]">Jelajahi</a>
                    <a href="#pesanan" class="text-gray-500 hover:text-[#174b35]">Pesanan</a>
                    <a href="#keranjang" class="text-gray-500 hover:text-[#174b35]">Keranjang</a>
                </nav>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-400">Customer</p>
                    </div>

                    <div class="w-10 h-10 rounded-full bg-[#174b35] text-white flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Logout"
                            class="text-gray-400 hover:text-red-500 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative min-h-[390px] lg:min-h-[430px] overflow-hidden flex items-center">

        <!-- Background Image Full Section -->
        <img
            src="{{ asset('images/bg.jpg') }}"
            alt="Makanan surplus Sisa.in"
            class="absolute inset-0 w-full h-full object-cover object-center"
        >

        <!-- Dark Green Overlay -->
        <div class="absolute inset-0 bg-linear-to-r from-[#102f23]/90 via-[#174b35]/70 to-[#174b35]/30"></div>

        <!-- Hero Content -->
        <div class="relative z-10 w-full px-6 lg:px-12 xl:px-16 py-14">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold tracking-widest text-green-200 mb-4 uppercase">
                    Selamat datang di Sisa.in
                </p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight text-white">
                    Makan Enak,<br>
                    <span class="text-[#b9e5a9]">Lebih Hemat!</span>
                </h1>
                <p class="text-green-50 mt-5 max-w-lg leading-relaxed">
                    Temukan makanan surplus berkualitas dengan harga lebih terjangkau
                    dan bantu kurangi food waste bersama Sisa.in.
                </p>

                <!-- Search -->
                <form action="#" method="GET" class="mt-7 max-w-lg relative">
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari makanan favoritmu..."
                        class="w-full rounded-xl bg-white text-gray-800 placeholder:text-gray-400 px-12 py-4 text-sm shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300"
                    >
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20"
                        viewBox="0 0 24 24"
                        fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                </form>
            </div>
        </div>
    </section>


    <!-- MAIN CONTENT -->
    <main class="w-full px-6 lg:px-12 xl:px-16 py-8">

        <!-- CATEGORIES -->
        <section id="kategori" class="mb-9">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold">Kategori</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Pilih kategori yang kamu suka
                    </p>
                </div>

                <a href="#produk" class="text-sm font-semibold text-[#174b35]">
                    Lihat semua →
                </a>
            </div>

            <div class="flex flex-wrap gap-3">

                <button class="px-6 py-3 rounded-full bg-[#174b35] text-white text-sm font-medium shadow-sm">
                    Semua
                </button>

                <button class="px-6 py-3 rounded-full bg-white border border-gray-200 text-sm hover:border-[#174b35]">
                    Makanan Berat
                </button>

                <button class="px-6 py-3 rounded-full bg-white border border-gray-200 text-sm hover:border-[#174b35]">
                    Camilan
                </button>

                <button class="px-6 py-3 rounded-full bg-white border border-gray-200 text-sm hover:border-[#174b35]">
                    Minuman
                </button>

                <button class="px-6 py-3 rounded-full bg-white border border-gray-200 text-sm hover:border-[#174b35]">
                    Roti & Kue
                </button>

            </div>
        </section>


        <!-- PRODUCTS -->
        <section id="produk">

            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-bold">Surplus Food Terdekat</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Pilihan makanan hemat untukmu
                    </p>
                </div>

                <a href="#produk" class="text-sm font-semibold text-[#174b35]">
                    Lihat semua →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- PRODUCT 1 -->
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ asset('images/products/nasi-goreng.jpg') }}"
                            alt="Nasi Goreng"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'">
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-gray-500">Kantin Sisa.in</p>
                        <h3 class="font-bold mt-1">Nasi Goreng</h3>

                        <div class="flex items-center gap-2 mt-3">
                            <p class="font-bold text-[#187345] text-lg">Rp10.000</p>
                            <p class="text-xs text-gray-400 line-through">Rp15.000</p>
                        </div>

                        <p class="text-xs text-gray-500 mt-3">Pickup 17:00 – 19:00</p>

                        <button class="w-full mt-4 py-2.5 rounded-full bg-[#174b35] text-white text-sm font-semibold hover:bg-[#103b29] transition">
                            Lihat Produk
                        </button>
                    </div>
                </article>


                <!-- PRODUCT 2 -->
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ asset('images/products/nasi-ayam.jpg') }}"
                            alt="Nasi Ayam"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'">
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-gray-500">Kantin Sisa.in</p>
                        <h3 class="font-bold mt-1">Nasi Ayam</h3>

                        <div class="flex items-center gap-2 mt-3">
                            <p class="font-bold text-[#187345] text-lg">Rp12.000</p>
                            <p class="text-xs text-gray-400 line-through">Rp18.000</p>
                        </div>

                        <p class="text-xs text-gray-500 mt-3">Pickup 17:00 – 19:00</p>

                        <button class="w-full mt-4 py-2.5 rounded-full bg-[#174b35] text-white text-sm font-semibold hover:bg-[#103b29] transition">
                            Lihat Produk
                        </button>
                    </div>
                </article>


                <!-- PRODUCT 3 -->
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ asset('images/products/roti-cokelat.jpg') }}"
                            alt="Roti Cokelat"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'">
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-gray-500">Kantin Sisa.in</p>
                        <h3 class="font-bold mt-1">Roti Cokelat</h3>

                        <div class="flex items-center gap-2 mt-3">
                            <p class="font-bold text-[#187345] text-lg">Rp6.000</p>
                            <p class="text-xs text-gray-400 line-through">Rp10.000</p>
                        </div>

                        <p class="text-xs text-gray-500 mt-3">Pickup 16:00 – 19:00</p>

                        <button class="w-full mt-4 py-2.5 rounded-full bg-[#174b35] text-white text-sm font-semibold hover:bg-[#103b29] transition">
                            Lihat Produk
                        </button>
                    </div>
                </article>


                <!-- PRODUCT 4 -->
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ asset('images/products/es-teh.jpg') }}"
                            alt="Es Teh"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'">
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-gray-500">Kantin Sisa.in</p>
                        <h3 class="font-bold mt-1">Es Teh</h3>

                        <div class="flex items-center gap-2 mt-3">
                            <p class="font-bold text-[#187345] text-lg">Rp3.000</p>
                            <p class="text-xs text-gray-400 line-through">Rp5.000</p>
                        </div>

                        <p class="text-xs text-gray-500 mt-3">Pickup 16:00 – 19:00</p>

                        <button class="w-full mt-4 py-2.5 rounded-full bg-[#174b35] text-white text-sm font-semibold hover:bg-[#103b29] transition">
                            Lihat Produk
                        </button>
                    </div>
                </article>

            </div>
        </section>


        <!-- PICKUP INFORMATION -->
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


    <!-- FOOTER -->
    <footer class="mt-12 bg-white border-t border-gray-100">
        <div class="w-full px-6 lg:px-12 xl:px-16 py-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="font-bold text-[#174b35]">Sisa.in</p>
            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Sisa.in. Mengurangi food waste bersama.
            </p>
        </div>
    </footer>

</body>
</html>
