
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Merchant Center - Sisa.in')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f3f6ef] text-gray-800">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-[#174b35] text-white hidden md:flex flex-col shrink-0">

            <div class="px-7 py-7 border-b border-white/10">
                <h1 class="text-2xl font-bold">
                    Sisa<span class="text-green-300">.in</span>
                </h1>
                <p class="text-xs text-green-200 mt-1">Merchant Center</p>
            </div>

            <div class="px-5 py-6 border-b border-white/10">
                <p class="text-xs text-green-200 mb-2">TOKO ANDA</p>
                <h2 class="font-semibold text-sm">
                    {{ auth()->user()->merchant?->business_name ?? 'Nama Toko' }}
                </h2>
                <p class="text-xs text-green-200 mt-1">Akun Merchant</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <p class="text-xs text-green-200 px-3 mb-3">MENU UTAMA</p>

                <a href="{{ route('merchant.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition
                   {{ request()->routeIs('merchant.dashboard') ? 'bg-white/15 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                    Dashboard
                </a>

                <a href="{{ route('merchant.products.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition
                   {{ request()->routeIs('merchant.products.*') ? 'bg-white/15 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                    Produk Saya
                </a>

                <a href="{{ route('merchant.orders.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-green-50 hover:text-green-700">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 3h2l2.2 11.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 7H6" />
                        <circle cx="10" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>

                    <span>Pesanan Masuk</span>
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-green-100 hover:bg-white/10 text-sm transition">
                    Riwayat Penjualan
                </a>


                <p class="text-xs text-green-200 px-3 pt-7 mb-3">PENGATURAN</p>

                <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-green-100 hover:bg-white/10 text-sm transition">
                    Profil Toko
                </a>

                <a href="{{ route('merchant.qris.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition
                {{ request()->is('merchant/qris*') ? 'bg-white/15 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                        <path d="M14 14h3v3h-3zM20 14v2M14 20h2M19 19h2v2h-2z"/>
                    </svg>
                    Pengaturan QRIS
                </a>

            </nav>

            {{-- LOGOUT --}}
            <div class="p-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-200 hover:bg-white/10 text-sm transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-w-0">

            {{-- HEADER --}}
            <header class="bg-white border-b border-gray-100 px-6 lg:px-10 py-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-xs text-gray-400 mt-1">
                            @yield('page-description', 'Kelola aktivitas toko Anda.')
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-400">Merchant</p>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-[#174b35] text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <div class="p-6 lg:p-10">
                @yield('content')
            </div>

        </main>
    </div>
</body>
</html>
