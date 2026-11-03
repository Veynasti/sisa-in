
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Merchant - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f3f6ef] text-gray-800">

    <div class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-[#174b35] text-white hidden md:flex flex-col shrink-0">

            <!-- Logo -->
            <div class="px-7 py-7 border-b border-white/10">
                <h1 class="text-2xl font-bold">
                    Sisa<span class="text-green-300">.in</span>
                </h1>

                <p class="text-xs text-green-200 mt-1">
                    Merchant Center
                </p>
            </div>

            <!-- Store Information -->
            <div class="px-5 py-6 border-b border-white/10">
                <p class="text-xs text-green-200 mb-2">
                    TOKO ANDA
                </p>

                <h2 class="font-semibold text-sm">
                    {{ auth()->user()->merchant?->business_name ?? 'Nama Toko' }}
                </h2>

                <p class="text-xs text-green-200 mt-1">
                    Akun Merchant
                </p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">

                <p class="text-xs text-green-200 px-3 mb-3">
                    MENU UTAMA
                </p>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/15 text-white font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-green-100 hover:bg-white/10 text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                        <rect x="3" y="3" width="18" height="18" rx="3"/>
                    </svg>
                    Produk Saya
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-green-100 hover:bg-white/10 text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2h12l3 6H3l3-6Z"/>
                        <path d="M3 8v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/>
                        <path d="M9 22v-8h6v8"/>
                    </svg>
                    Pesanan Masuk
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-green-100 hover:bg-white/10 text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18"/>
                        <path d="m19 9-5 5-4-4-5 5"/>
                    </svg>
                    Riwayat Penjualan
                </a>

                <p class="text-xs text-green-200 px-3 pt-7 mb-3">
                    PENGATURAN
                </p>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-green-100 hover:bg-white/10 text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="m19.4 15 .1.1a1.7 1.7 0 0 1-2.4 2.4l-.1-.1a1.7 1.7 0 0 0-2.9 1.2v.2a1.7 1.7 0 0 1-3.4 0v-.2a1.7 1.7 0 0 0-2.9-1.2l-.1.1a1.7 1.7 0 0 1-2.4-2.4l.1-.1a1.7 1.7 0 0 0-1.2-2.9H4a1.7 1.7 0 0 1 0-3.4h.2a1.7 1.7 0 0 0 1.2-2.9l-.1-.1a1.7 1.7 0 0 1 2.4-2.4l.1.1a1.7 1.7 0 0 0 2.9-1.2V2a1.7 1.7 0 0 1 3.4 0v.2a1.7 1.7 0 0 0 2.9 1.2l.1-.1a1.7 1.7 0 0 1 2.4 2.4l-.1.1a1.7 1.7 0 0 0 1.2 2.9h.2a1.7 1.7 0 0 1 0 3.4h-.2a1.7 1.7 0 0 0-1.2 2.9Z"/>
                    </svg>
                    Profil Toko
                </a>

            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-200 hover:bg-white/10 text-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

        </aside>


        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0">

            <!-- HEADER -->
            <header class="bg-white border-b border-gray-100 px-6 lg:px-10 py-5">
                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h1 class="text-lg font-bold text-gray-900">
                            Dashboard
                        </h1>
                        <p class="text-xs text-gray-400 mt-1">
                            Kelola aktivitas toko Anda.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-400">
                                Merchant
                            </p>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-[#174b35] text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>

                </div>
            </header>


            <!-- PAGE CONTENT -->
            <div class="p-6 lg:p-10">

                <!-- Welcome -->
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


                <!-- Store Banner -->
                <section class="bg-gradient-to-r from-[#174b35] to-[#286c4b] rounded-2xl p-7 lg:p-9 text-white mb-8">
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


                <!-- SUMMARY CARDS -->
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

                        <!-- Card 1 -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-700 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 3h18v18H3z"/>
                                    <path d="M3 9h18M9 21V9"/>
                                </svg>
                            </div>

                            <p class="text-sm text-gray-500">Produk Aktif</p>
                            <h4 class="text-2xl font-bold mt-2">—</h4>
                            <p class="text-xs text-gray-400 mt-2">Jumlah produk tersedia</p>
                        </div>


                        <!-- Card 2 -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2h12l3 6H3l3-6Z"/>
                                    <path d="M3 8v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/>
                                </svg>
                            </div>

                            <p class="text-sm text-gray-500">Pesanan Masuk</p>
                            <h4 class="text-2xl font-bold mt-2">—</h4>
                            <p class="text-xs text-gray-400 mt-2">Pesanan yang perlu diproses</p>
                        </div>


                        <!-- Card 3 -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 6v6l4 2"/>
                                </svg>
                            </div>

                            <p class="text-sm text-gray-500">Siap Diambil</p>
                            <h4 class="text-2xl font-bold mt-2">—</h4>
                            <p class="text-xs text-gray-400 mt-2">Pesanan menunggu pickup</p>
                        </div>


                        <!-- Card 4 -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </div>

                            <p class="text-sm text-gray-500">Total Penjualan</p>
                            <h4 class="text-2xl font-bold mt-2">—</h4>
                            <p class="text-xs text-gray-400 mt-2">Akumulasi transaksi selesai</p>
                        </div>

                    </div>
                </section>


                <!-- RECENT ORDERS -->
                <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    <div class="p-5 lg:p-6 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900">
                                Pesanan Terbaru
                            </h3>

                            <p class="text-xs text-gray-400 mt-1">
                                Pantau pesanan yang masuk ke toko Anda.
                            </p>
                        </div>

                        <a href="#"
                           class="text-sm font-semibold text-green-700 hover:text-green-800">
                            Lihat semua
                        </a>
                    </div>

                    <div class="p-10 text-center">
                        <div class="w-14 h-14 rounded-full bg-[#f3f6ef] flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                 viewBox="0 0 24 24" fill="none" stroke="#174b35"
                                 stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2h12l3 6H3l3-6Z"/>
                                <path d="M3 8v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/>
                            </svg>
                        </div>

                        <h4 class="font-semibold text-gray-800">
                            Belum ada pesanan
                        </h4>

                        <p class="text-sm text-gray-400 mt-2">
                            Pesanan customer akan muncul di sini.
                        </p>
                    </div>

                </section>

            </div>

        </main>

    </div>

</body>
</html>
