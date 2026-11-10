<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Merchant - Sisa.in</title>
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
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-green-50 transition hover:bg-white/10">

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
               class="flex items-center gap-3 rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white">

                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10h18"/>
                    <path d="M5 10V20H19V10"/>
                    <path d="M3 10L5 4H19L21 10"/>
                    <path d="M9 20V14H15V20"/>
                </svg>

                <span>Verifikasi Merchant</span>
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
                    Admin / Verifikasi Merchant
                </p>

                <h2 class="mt-1 text-2xl font-bold text-gray-800 sm:text-3xl">
                    Verifikasi Merchant
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Kelola dan periksa pendaftaran toko yang masuk ke Sisa.in.
                </p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-3">
                <p class="text-xs text-gray-500">Login sebagai</p>
                <p class="font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>
            </div>

        </div>


        {{-- NOTIFIKASI SUKSES --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- NOTIFIKASI ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif


        {{-- STATISTIK MERCHANT --}}
        <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-3">

            {{-- MENUNGGU VERIFIKASI --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Menunggu Verifikasi
                </p>

                <h3 class="mt-2 text-3xl font-bold text-amber-500">
                    {{ $pendingCount }}
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Merchant pending
                </p>
            </div>

            {{-- DISETUJUI --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Disetujui
                </p>

                <h3 class="mt-2 text-3xl font-bold text-green-600">
                    {{ $approvedCount }}
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Merchant approved
                </p>
            </div>

            {{-- DITOLAK --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Ditolak
                </p>

                <h3 class="mt-2 text-3xl font-bold text-red-500">
                    {{ $rejectedCount }}
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Merchant rejected
                </p>
            </div>

        </div>


        {{-- DAFTAR PENDAFTARAN MERCHANT --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800">
                    Daftar Pendaftaran Toko
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Informasi merchant yang telah mendaftar di Sisa.in.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-212.5 text-left text-sm">

                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Toko</th>
                            <th class="px-6 py-4 font-semibold">Pemilik</th>
                            <th class="px-6 py-4 font-semibold">Kontak</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 text-center font-semibold">Tindakan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($merchants as $merchant)

                            <tr class="transition hover:bg-gray-50">

                                {{-- NAMA TOKO --}}
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">
                                        {{ $merchant->business_name }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $merchant->address }}
                                    </p>
                                </td>

                                {{-- PEMILIK --}}
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-700">
                                        {{ $merchant->user->name ?? '-' }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ $merchant->user->email ?? '-' }}
                                    </p>
                                </td>

                                {{-- KONTAK --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $merchant->phone ?? '-' }}
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

                                {{-- TINDAKAN --}}
                                <td class="px-6 py-4">

                                    @if ($merchant->verification_status === 'pending')

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- SETUJUI --}}
                                            <form
                                                action="{{ route('admin.merchants.update-status', $merchant) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menyetujui toko ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <input
                                                    type="hidden"
                                                    name="verification_status"
                                                    value="approved"
                                                >

                                                <button
                                                    type="submit"
                                                    class="inline-flex min-w-21.25 items-center justify-center rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-700"
                                                >
                                                    Setujui
                                                </button>
                                            </form>

                                            {{-- TOLAK --}}
                                            <form
                                                action="{{ route('admin.merchants.update-status', $merchant) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menolak pendaftaran toko ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <input
                                                    type="hidden"
                                                    name="verification_status"
                                                    value="rejected"
                                                >

                                                <button
                                                    type="submit"
                                                    class="inline-flex min-w-21.25 items-center justify-center rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-600"
                                                >
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
                                    <p class="font-medium text-gray-500">
                                        Belum ada pendaftaran merchant.
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
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

</body>
</html>
