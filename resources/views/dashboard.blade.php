<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 p-6 hidden md:block">

            <!-- Logo -->
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-green-600">
                    Sisa.in
                </h1>

                <p class="text-xs text-gray-400 mt-1">
                    Save Food. Save Money.
                </p>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">

                <a href="/dashboard"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 text-green-600 font-semibold">
                    🏠
                    <span>Dashboard</span>
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50">
                    🔍
                    <span>Jelajahi</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50">
                    📦
                    <span>Pesanan</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50">
                    🧾
                    <span>Riwayat</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50">
                    👤
                    <span>Profil</span>
                </a>
                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition duration-200"
                    >
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </nav>

        </aside>


        <!-- Main Content -->
        <main class="flex-1">

            <!-- Header -->
            <header class="bg-white border-b border-gray-100 px-6 md:px-10 py-5">

                <div class="flex items-center justify-between gap-6">

                    <!-- Search -->
                    <div class="relative w-full max-w-xl">

                        <input
                            type="text"
                            placeholder="Cari makanan, merchant, atau kategori..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 pl-11 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >

                        <span class="absolute left-4 top-3.5 text-gray-400">
                            🔍
                        </span>

                    </div>

                    <!-- User -->
                    <div class="flex items-center gap-3">

                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-gray-400">
                                Customer
                            </p>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </header>


            <!-- Content -->
            <div class="p-6 md:p-10">

                <!-- Welcome -->
                <section class="mb-8">

                    <h2 class="text-3xl font-bold">
                        Selamat datang, {{ auth()->user()->name }}! 👋
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Temukan surplus food berkualitas dengan harga lebih hemat.
                    </p>

                </section>


                <!-- Banner -->
                <section class="bg-green-600 rounded-2xl p-8 text-white mb-10">

                    <div class="max-w-2xl">

                        <p class="text-green-100 text-sm font-medium mb-2">
                            SURPLUS FOOD HARI INI
                        </p>

                        <h3 class="text-3xl font-bold mb-3">
                            Makanan layak konsumsi,
                            harga lebih terjangkau.
                        </h3>

                        <p class="text-green-100 mb-6">
                            Temukan makanan surplus dari merchant di sekitar kampusmu.
                        </p>

                        <button class="bg-white text-green-600 px-5 py-3 rounded-xl font-semibold hover:bg-green-50">
                            Jelajahi Sekarang
                        </button>

                    </div>

                </section>


                <!-- Categories -->
                <section class="mb-10">

                    <div class="flex items-center justify-between mb-5">

                        <h3 class="text-xl font-bold">
                            Kategori
                        </h3>

                        <a href="#" class="text-sm text-green-600 font-semibold">
                            Lihat semua
                        </a>

                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                        <div class="bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-sm cursor-pointer">
                            <div class="text-3xl mb-3">🍚</div>
                            <p class="font-semibold">Makanan Berat</p>
                            <p class="text-sm text-gray-400 mt-1">
                                Makanan utama
                            </p>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-sm cursor-pointer">
                            <div class="text-3xl mb-3">🥐</div>
                            <p class="font-semibold">Snack</p>
                            <p class="text-sm text-gray-400 mt-1">
                                Camilan
                            </p>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-sm cursor-pointer">
                            <div class="text-3xl mb-3">🥤</div>
                            <p class="font-semibold">Minuman</p>
                            <p class="text-sm text-gray-400 mt-1">
                                Minuman segar
                            </p>
                        </div>

                    </div>

                </section>


                <!-- Products -->
                <section>

                    <div class="flex items-center justify-between mb-5">

                        <div>
                            <h3 class="text-xl font-bold">
                                Surplus Food Terdekat
                            </h3>

                            <p class="text-sm text-gray-400 mt-1">
                                Pilihan makanan hemat untukmu
                            </p>
                        </div>

                        <a href="#" class="text-sm text-green-600 font-semibold">
                            Lihat semua
                        </a>

                    </div>


                    <!-- Product Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                        <!-- Product -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition">

                            <div class="h-40 bg-gray-100 flex items-center justify-center text-5xl">
                                🍛
                            </div>

                            <div class="p-5">

                                <p class="text-xs text-gray-400 mb-1">
                                    Kantin Sisa.in
                                </p>

                                <h4 class="font-bold text-lg">
                                    Nasi Goreng
                                </h4>

                                <div class="mt-3">
                                    <span class="text-sm text-gray-400 line-through">
                                        Rp15.000
                                    </span>

                                    <p class="text-xl font-bold text-green-600">
                                        Rp10.000
                                    </p>
                                </div>

                                <div class="text-xs text-gray-400 mt-3">
                                    🕐 17:00 - 19:00
                                </div>

                                <button class="w-full mt-4 bg-green-600 text-white py-2.5 rounded-xl font-semibold hover:bg-green-700">
                                    Lihat Produk
                                </button>

                            </div>

                        </div>


                        <!-- Product -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition">

                            <div class="h-40 bg-gray-100 flex items-center justify-center text-5xl">
                                🍗
                            </div>

                            <div class="p-5">

                                <p class="text-xs text-gray-400 mb-1">
                                    Kantin Sisa.in
                                </p>

                                <h4 class="font-bold text-lg">
                                    Nasi Ayam
                                </h4>

                                <div class="mt-3">
                                    <span class="text-sm text-gray-400 line-through">
                                        Rp18.000
                                    </span>

                                    <p class="text-xl font-bold text-green-600">
                                        Rp12.000
                                    </p>
                                </div>

                                <div class="text-xs text-gray-400 mt-3">
                                    🕐 17:00 - 19:00
                                </div>

                                <button class="w-full mt-4 bg-green-600 text-white py-2.5 rounded-xl font-semibold hover:bg-green-700">
                                    Lihat Produk
                                </button>

                            </div>

                        </div>


                        <!-- Product -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition">

                            <div class="h-40 bg-gray-100 flex items-center justify-center text-5xl">
                                🥐
                            </div>

                            <div class="p-5">

                                <p class="text-xs text-gray-400 mb-1">
                                    Kantin Sisa.in
                                </p>

                                <h4 class="font-bold text-lg">
                                    Roti Cokelat
                                </h4>

                                <div class="mt-3">
                                    <span class="text-sm text-gray-400 line-through">
                                        Rp10.000
                                    </span>

                                    <p class="text-xl font-bold text-green-600">
                                        Rp6.000
                                    </p>
                                </div>

                                <div class="text-xs text-gray-400 mt-3">
                                    🕐 16:00 - 19:00
                                </div>

                                <button class="w-full mt-4 bg-green-600 text-white py-2.5 rounded-xl font-semibold hover:bg-green-700">
                                    Lihat Produk
                                </button>

                            </div>

                        </div>


                        <!-- Product -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition">

                            <div class="h-40 bg-gray-100 flex items-center justify-center text-5xl">
                                🥤
                            </div>

                            <div class="p-5">

                                <p class="text-xs text-gray-400 mb-1">
                                    Kantin Sisa.in
                                </p>

                                <h4 class="font-bold text-lg">
                                    Es Teh
                                </h4>

                                <div class="mt-3">
                                    <span class="text-sm text-gray-400 line-through">
                                        Rp5.000
                                    </span>

                                    <p class="text-xl font-bold text-green-600">
                                        Rp3.000
                                    </p>
                                </div>

                                <div class="text-xs text-gray-400 mt-3">
                                    🕐 16:00 - 19:00
                                </div>

                                <button class="w-full mt-4 bg-green-600 text-white py-2.5 rounded-xl font-semibold hover:bg-green-700">
                                    Lihat Produk
                                </button>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </main>

    </div>

</body>
</html>
