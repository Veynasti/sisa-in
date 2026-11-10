<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sisa.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    {{-- SIDEBAR ADMIN --}}
    <aside class="fixed inset-y-0 left-0 z-40 hidden h-screen w-64 flex-col overflow-y-auto bg-[#174b35] text-white md:flex">

        {{-- LOGO --}}
        <div class="border-b border-white/10 px-6 py-6">
            <h1 class="text-3xl font-bold">
                Sisa<span class="text-green-300">.in</span>
            </h1>
            <p class="mt-1 text-xs text-green-100">Admin Panel</p>
        </div>

        {{-- INFORMASI ADMIN --}}
        <div class="border-b border-white/10 px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-green-300">
                Akun Admin
            </p>

            <p class="mt-2 font-semibold text-white">
                {{ auth()->user()->name }}
            </p>

            <div class="mt-2 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-green-400"></span>
                <span class="text-xs text-green-100">Administrator</span>
            </div>
        </div>

        {{-- NAVIGASI --}}
        <nav class="flex-1 space-y-2 px-4 py-6">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-green-300">
                Menu Utama
            </p>

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white">

                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                </svg>

                <span>Dashboard</span>
            </a>

            {{-- VERIFIKASI MERCHANT --}}
            <a href="{{ route('admin.merchants.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-green-50 transition hover:bg-white/10">

                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10h18"/>
                    <path d="M5 10V20H19V10"/>
                    <path d="M3 10L5 4H19L21 10"/>
                    <path d="M9 20V14H15V20"/>
                </svg>

                <span class="flex-1">Verifikasi Merchant</span>

                @if ($pendingCount > 0)
                    <span class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1.5 text-xs font-semibold text-white">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            {{-- VERIFIKASI SETORAN --}}
            <a href="{{ route('admin.commissions.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-green-50 transition hover:bg-white/10">

                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                    <path d="M2 10H22"/>
                    <path d="M6 15H9"/>
                    <path d="M16 15H18"/>
                </svg>

                <span>Verifikasi Setoran</span>
            </a>

            {{-- KEUNTUNGAN SISA.IN --}}
            <a href="{{ route('admin.withdrawals.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('admin.withdrawals.*')
                    ? 'bg-white/15 text-white font-semibold'
                    : 'text-green-50 hover:bg-white/10' }}">

                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 17l6-6 4 4 8-9"/>
                    <path d="M15 6h6v6"/>
                    <path d="M3 21h18"/>
                </svg>

                <span>Keuntungan Sisa.in</span>
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="mt-auto border-t border-white/10 p-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-white/10 hover:text-white">

                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 17L15 12L10 7"/>
                        <path d="M15 12H3"/>
                        <path d="M12 3H19C20.1 3 21 3.9 21 5V19C21 20.1 20.1 21 19 21H12"/>
                    </svg>

                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>


    {{-- MAIN CONTENT --}}
    <main class="ml-0 min-w-0 flex-1 p-5 sm:p-8 lg:p-10 md:ml-64">

        {{-- HEADER --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Admin / Dashboard
                </p>

                <h2 class="mt-1 text-2xl font-bold text-gray-800 sm:text-3xl">
                    Dashboard Admin
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Selamat datang di halaman pengelolaan Sisa.in.
                </p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-3">
                <p class="text-xs text-gray-500">Login sebagai</p>
                <p class="font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>
            </div>

        </div>


        {{-- WELCOME BANNER --}}
        <div class="mb-8 rounded-2xl bg-[#174b35] p-6 text-white sm:p-8">

            <p class="mb-2 text-sm text-green-200">
                Sisa.in Administration
            </p>

            <h3 class="mb-2 text-2xl font-bold">
                Selamat datang, Admin!
            </h3>

            <p class="max-w-2xl text-sm leading-relaxed text-green-100">
                Pantau aktivitas platform, kelola merchant, dan pastikan
                setiap toko yang bergabung telah melalui proses verifikasi.
            </p>

            <a href="{{ route('admin.merchants.index') }}"
               class="mt-5 inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-[#174b35] transition hover:bg-green-50">

                <svg class="h-4 w-4" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10h18"/>
                    <path d="M5 10V20H19V10"/>
                    <path d="M3 10L5 4H19L21 10"/>
                </svg>

                Kelola Merchant
            </a>

        </div>


        {{-- STATISTIK UTAMA --}}
        <div class="mb-8">

            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    Ringkasan Platform
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Gambaran umum aktivitas platform Sisa.in.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL MERCHANT --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total Merchant</p>

                    <h4 class="mt-3 text-3xl font-bold text-gray-800">
                        {{ $totalMerchants }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Seluruh toko terdaftar
                    </p>
                </div>

                {{-- CUSTOMER --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total Customer</p>

                    <h4 class="mt-3 text-3xl font-bold text-blue-600">
                        {{ $totalCustomers }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Pengguna sebagai customer
                    </p>
                </div>

                {{-- PRODUCT --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total Produk</p>

                    <h4 class="mt-3 text-3xl font-bold text-purple-600">
                        {{ $totalProducts }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Produk terdaftar
                    </p>
                </div>

                {{-- ORDER --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Total Pesanan</p>

                    <h4 class="mt-3 text-3xl font-bold text-orange-500">
                        {{ $totalOrders }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Pesanan yang tercatat
                    </p>
                </div>

            </div>
        </div>


        {{-- STATUS VERIFIKASI --}}
        <div class="mb-8">

            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Status Verifikasi Merchant
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Ringkasan proses pemeriksaan pendaftaran toko.
                    </p>
                </div>

                <a href="{{ route('admin.merchants.index') }}"
                   class="text-sm font-semibold text-green-700 transition hover:text-green-800">
                    Lihat semua merchant →
                </a>

            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">

                {{-- PENDING --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    </div>

                    <h4 class="mt-3 text-3xl font-bold text-amber-500">
                        {{ $pendingCount }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Merchant perlu diperiksa
                    </p>

                </div>

                {{-- APPROVED --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">Disetujui</p>
                        <span class="h-3 w-3 rounded-full bg-green-500"></span>
                    </div>

                    <h4 class="mt-3 text-3xl font-bold text-green-600">
                        {{ $approvedCount }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Merchant telah disetujui
                    </p>

                </div>

                {{-- REJECTED --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">Ditolak</p>
                        <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    </div>

                    <h4 class="mt-3 text-3xl font-bold text-red-500">
                        {{ $rejectedCount }}
                    </h4>

                    <p class="mt-2 text-xs text-gray-400">
                        Pendaftaran ditolak
                    </p>

                </div>

            </div>
        </div>


        {{-- MERCHANT TERBARU --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Merchant Terbaru
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Lima pendaftaran merchant terakhir.
                    </p>
                </div>

                <a href="{{ route('admin.merchants.index') }}"
                   class="text-sm font-semibold text-green-700 transition hover:text-green-800">
                    Kelola merchant →
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-162.5 text-left text-sm">

                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Toko</th>
                            <th class="px-6 py-4 font-semibold">Pemilik</th>
                            <th class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($recentMerchants as $merchant)

                            <tr class="transition hover:bg-gray-50">

                                {{-- NAMA TOKO --}}
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $merchant->business_name }}
                                </td>

                                {{-- PEMILIK --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $merchant->user->name ?? '-' }}
                                </td>

                                {{-- TANGGAL DAFTAR --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $merchant->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4">

                                    @if ($merchant->verification_status === 'pending')

                                        <span class="inline-block rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Menunggu
                                        </span>

                                    @elseif ($merchant->verification_status === 'approved')

                                        <span class="inline-block rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                            Disetujui
                                        </span>

                                    @else

                                        <span class="inline-block rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                            Ditolak
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada merchant yang terdaftar.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</body>
</html>
