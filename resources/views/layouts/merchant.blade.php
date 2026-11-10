<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Merchant Center - Sisa.in')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen overflow-hidden bg-[#f3f6ef] text-gray-800">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside class="sticky top-0 hidden h-screen w-64 shrink-0 flex-col bg-[#174b35] text-white md:flex">

            {{-- BRAND --}}
            <div class="border-b border-white/10 px-6 py-6">
                <h1 class="text-2xl font-bold tracking-tight">
                    Sisa<span class="text-green-300">.in</span>
                </h1>
                <p class="mt-1 text-xs text-green-200">
                    Merchant Center
                </p>
            </div>

            {{-- STORE INFORMATION --}}
            <div class="border-b border-white/10 px-6 py-5">
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-wider text-green-300">
                    Toko Anda
                </p>

                <h2 class="truncate text-sm font-semibold text-white">
                    {{ auth()->user()->merchant?->business_name ?? 'Nama Toko' }}
                </h2>

                <div class="mt-2 flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-green-400"></span>
                    <p class="text-xs text-green-200">Akun Merchant</p>
                </div>
            </div>

            {{-- NAVIGATION --}}
            <nav class="min-h-0 flex-1 space-y-7 overflow-y-auto px-4 py-6">

                {{-- MENU UTAMA --}}
                <div>
                    <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-green-300">
                        Menu Utama
                    </p>

                    {{-- Dashboard --}}
                    <a href="{{ route('merchant.dashboard') }}"
                       class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                       {{ request()->routeIs('merchant.dashboard')
                            ? 'bg-white/15 font-semibold text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                        </svg>

                        <span>Dashboard</span>
                    </a>

                    {{-- Produk --}}
                    <a href="{{ route('merchant.products.index') }}"
                       class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                       {{ request()->routeIs('merchant.products.*')
                            ? 'bg-white/15 font-semibold text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 8.5L12 13 3 8.5M12 13v9M4 8l8-4 8 4v8l-8 5-8-5V8Z"
                                  stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <span>Produk Saya</span>
                    </a>

                    {{-- Pesanan --}}
                    <a href="{{ route('merchant.orders.index') }}"
                       class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                       {{ request()->routeIs('merchant.orders.*')
                            ? 'bg-white/15 font-semibold text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h2l2.2 11.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 7H6"
                                  stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="10" cy="20" r="1"/>
                            <circle cx="18" cy="20" r="1"/>
                        </svg>

                        <span>Pesanan Masuk</span>
                    </a>
                </div>

                {{-- PENJUALAN --}}
                <div>
                    <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-green-300">
                        Penjualan
                    </p>

                    {{-- Riwayat Penjualan --}}
                    <a href="{{ route('merchant.sales.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                        {{ request()->routeIs('merchant.sales.*')
                            ? 'bg-white/15 font-semibold text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 19V5M4 19h17M8 15l4-4 3 3 5-6"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                        <span>Riwayat Penjualan</span>
                    </a>

                    <a href="{{ route('merchant.commissions.index') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 transition
                    {{ request()->routeIs('merchant.commissions.*')
                            ? 'bg-white/15 text-white font-semibold'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        {{-- ICON SETORAN KOMISI --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="shrink-0">

                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/>
                            <path d="M6 15h3"/>
                            <path d="M16 15h2"/>

                        </svg>

                        <span>Setoran Komisi</span>
                    </a>

                    {{-- KEUNTUNGAN BERSIH --}}
                    <a href="{{ route('merchant.earnings.index') }}"
                    class="mt-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                    {{ request()->routeIs('merchant.earnings.*')
                            ? 'bg-white/15 font-semibold text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path d="M3 17l6-6 4 4 8-9"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                            <path d="M15 6h6v6"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                        </svg>

                        <span>Keuntungan Bersih</span>
                    </a>

                </div>

                {{-- PENGATURAN --}}
                <div>
                    <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-green-300">
                        Pengaturan
                    </p>

                    {{-- Pengaturan QRIS --}}
                    <a href="{{ route('merchant.qris.index') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                       {{ request()->is('merchant/qris*')
                            ? 'bg-white/15 font-semibold text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white' }}">

                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="1.8"/>
                            <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="1.8"/>
                            <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="1.8"/>
                            <path d="M14 14h3v3h-3zM20 14v2M14 20h2M19 19h2v2h-2z"
                                  stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <span>Pengaturan QRIS</span>
                    </a>
                </div>

            </nav>

            {{-- LOGOUT --}}
            <div class="shrink-0 border-t border-white/10 p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-red-200 transition hover:bg-red-500/15 hover:text-white">

                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M10 17l5-5-5-5M15 12H3M12 3h6a2 2 0 012 2v14a2 2 0 01-2 2h-6"
                                  stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- MAIN AREA --}}
        <main class="flex h-screen min-w-0 flex-1 flex-col overflow-y-auto">

            {{-- HEADER --}}
            <header class="sticky top-0 z-20 shrink-0 border-b border-gray-100 bg-white px-6 py-4 lg:px-10">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h1 class="text-lg font-bold text-gray-900">
                            @yield('page-title', 'Dashboard')
                        </h1>

                        <p class="mt-1 text-xs text-gray-400">
                            @yield('page-description', 'Kelola aktivitas toko Anda.')
                        </p>
                    </div>

                    <div class="flex items-center gap-3">

                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-gray-400">
                                Merchant
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#174b35] font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </header>

            {{-- PAGE CONTENT --}}
            <div class="flex-1 p-6 lg:p-10">

                @yield('content')

            </div>

        </main>

    </div>

</body>
</html>
