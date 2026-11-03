
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Merchant - Sisa.in</title>
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
                    class="block px-4 py-3 rounded-xl hover:bg-white/10 transition">
                    Dashboard
                </a>

                <a href="{{ route('admin.merchants.index') }}"
                    class="block px-4 py-3 rounded-xl bg-white/15 font-semibold">
                    Verifikasi Merchant
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
                    <p class="text-sm text-gray-500">Admin / Verifikasi Merchant</p>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                        Verifikasi Merchant
                    </h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Kelola dan periksa pendaftaran toko yang masuk ke Sisa.in.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
                    <p class="text-xs text-gray-500">Login sebagai</p>
                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>
                </div>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERROR MESSAGE -->
            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- STATISTICS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                    <h3 class="text-3xl font-bold text-amber-500 mt-2">
                        {{ $pendingCount }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Merchant pending</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Disetujui</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">
                        {{ $approvedCount }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Merchant approved</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Ditolak</p>
                    <h3 class="text-3xl font-bold text-red-500 mt-2">
                        {{ $rejectedCount }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Merchant rejected</p>
                </div>

            </div>

            <!-- MERCHANT TABLE -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Daftar Pendaftaran Toko
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Informasi merchant yang telah mendaftar di Sisa.in.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-sm text-left">

                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-medium">Nama Toko</th>
                                <th class="px-6 py-4 font-medium">Pemilik</th>
                                <th class="px-6 py-4 font-medium">Kontak</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium text-center">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($merchants as $merchant)

                                <tr class="hover:bg-gray-50 transition">

                                    <!-- NAMA TOKO -->
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-800">
                                            {{ $merchant->business_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $merchant->address }}
                                        </p>
                                    </td>

                                    <!-- PEMILIK -->
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-700">
                                            {{ $merchant->user->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $merchant->user->email ?? '-' }}
                                        </p>
                                    </td>

                                    <!-- KONTAK -->
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $merchant->phone }}
                                    </td>

                                    <!-- STATUS -->
                                    <td class="px-6 py-4">
                                        @if ($merchant->verification_status === 'pending')
                                            <span class="inline-block px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold">
                                                Menunggu
                                            </span>
                                        @elseif ($merchant->verification_status === 'approved')
                                            <span class="inline-block px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    <!-- TINDAKAN -->
                                    <td class="px-6 py-4">
                                        @if ($merchant->verification_status === 'pending')

                                            <div class="flex items-center justify-center gap-2">

                                                <!-- TOMBOL SETUJUI -->
                                                <form
                                                    action="{{ route('admin.merchants.update-status', $merchant) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menyetujui toko ini?')"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden"
                                                        name="verification_status"
                                                        value="approved">

                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center min-w-[85px] px-3 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-semibold transition">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <!-- TOMBOL TOLAK -->
                                                <form
                                                    action="{{ route('admin.merchants.update-status', $merchant) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menolak pendaftaran toko ini?')"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden"
                                                        name="verification_status"
                                                        value="rejected">

                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center min-w-[85px] px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-semibold transition">
                                                        Tolak
                                                    </button>
                                                </form>

                                            </div>

                                        @else
                                            <div class="text-center">
                                                <span class="text-xs text-gray-400">
                                                    Sudah diproses
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-gray-500 font-medium">
                                            Belum ada pendaftaran merchant.
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Pendaftaran toko baru akan muncul di sini.
                                        </p>
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
