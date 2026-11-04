
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sisa.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="hidden md:flex w-64 shrink-0 bg-[#174b35] text-white flex-col p-6">

            <div class="mb-10">
                <h1 class="text-3xl font-bold">
                    Sisa<span class="text-green-300">.in</span>
                </h1>
                <p class="text-xs text-green-100 mt-1">Admin Panel</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded-xl bg-white/15 font-semibold">
                    Dashboard
                </a>

                <a href="{{ route('admin.merchants.index') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">
                    Verifikasi Merchant
                    @if ($pendingCount > 0)
                        <span class="ml-2 inline-flex items-center justify-center bg-red-500 text-white text-xs rounded-full min-w-5 h-5 px-1">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </nav>

            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-3 rounded-xl hover:bg-white/10 transition">
                        Keluar
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 p-5 sm:p-8 lg:p-10">

            <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div>
                    <p class="text-sm text-gray-500">Admin / Dashboard</p>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                        Dashboard Admin
                    </h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Selamat datang di halaman pengelolaan Sisa.in.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
                    <p class="text-xs text-gray-500">Login sebagai</p>
                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>
                </div>

            </div>

            <!-- WELCOME BANNER -->
            <div class="bg-[#174b35] rounded-2xl p-6 sm:p-8 text-white mb-8">
                <p class="text-sm text-green-200 mb-2">Sisa.in Administration</p>
                <h3 class="text-2xl font-bold mb-2">
                    Selamat datang, Admin!
                </h3>
                <p class="text-sm text-green-100 max-w-2xl">
                    Pantau aktivitas platform, kelola merchant, dan pastikan
                    setiap toko yang bergabung telah melalui proses verifikasi.
                </p>

                <a href="{{ route('admin.merchants.index') }}"
                    class="inline-block mt-5 bg-white text-[#174b35] px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-green-50 transition">
                    Kelola Merchant
                </a>
            </div>

            <!-- STATISTIK UTAMA -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    Ringkasan Platform
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                    <!-- TOTAL MERCHANT -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Merchant</p>
                        <h4 class="text-3xl font-bold text-gray-800 mt-3">
                            {{ $totalMerchants }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Seluruh toko terdaftar
                        </p>
                    </div>

                    <!-- CUSTOMER -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Customer</p>
                        <h4 class="text-3xl font-bold text-blue-600 mt-3">
                            {{ $totalCustomers }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Pengguna sebagai customer
                        </p>
                    </div>

                    <!-- PRODUCT -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Produk</p>
                        <h4 class="text-3xl font-bold text-purple-600 mt-3">
                            {{ $totalProducts }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Produk terdaftar
                        </p>
                    </div>

                    <!-- ORDER -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <h4 class="text-3xl font-bold text-orange-500 mt-3">
                            {{ $totalOrders }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Pesanan yang tercatat
                        </p>
                    </div>

                </div>
            </div>

            <!-- STATUS VERIFIKASI -->
            <div class="mb-8">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Status Verifikasi Merchant
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Ringkasan proses pemeriksaan pendaftaran toko.
                        </p>
                    </div>

                    <a href="{{ route('admin.merchants.index') }}"
                        class="text-sm font-semibold text-green-700 hover:text-green-800">
                        Lihat semua merchant →
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        </div>
                        <h4 class="text-3xl font-bold text-amber-500 mt-3">
                            {{ $pendingCount }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Merchant perlu diperiksa
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">Disetujui</p>
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        </div>
                        <h4 class="text-3xl font-bold text-green-600 mt-3">
                            {{ $approvedCount }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Merchant telah disetujui
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">Ditolak</p>
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        </div>
                        <h4 class="text-3xl font-bold text-red-500 mt-3">
                            {{ $rejectedCount }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">
                            Pendaftaran ditolak
                        </p>
                    </div>

                </div>
            </div>

            <!-- MERCHANT TERBARU -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Merchant Terbaru
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Lima pendaftaran merchant terakhir.
                        </p>
                    </div>

                    <a href="{{ route('admin.merchants.index') }}"
                        class="text-sm font-semibold text-green-700 hover:text-green-800">
                        Kelola merchant →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-162.5 text-sm text-left">

                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-medium">Nama Toko</th>
                                <th class="px-6 py-4 font-medium">Pemilik</th>
                                <th class="px-6 py-4 font-medium">Tanggal Daftar</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($recentMerchants as $merchant)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        {{ $merchant->business_name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $merchant->user->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $merchant->created_at?->format('d M Y') ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($merchant->verification_status === 'pending')
                                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold">
                                                Menunggu
                                            </span>
                                        @elseif ($merchant->verification_status === 'approved')
                                            <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold">
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
    </div>

</body>
</html>
