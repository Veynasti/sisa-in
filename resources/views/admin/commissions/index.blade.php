<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Setoran - Sisa.in</title>
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
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-green-50 transition hover:bg-white/10">

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
               class="flex items-center gap-3 rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white">

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
                    Admin / Verifikasi Setoran
                </p>

                <h2 class="mt-1 text-2xl font-bold text-gray-800 sm:text-3xl">
                    Verifikasi Setoran Komisi
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Periksa dan verifikasi pembayaran komisi dari merchant Sisa.in.
                </p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-3">
                <p class="text-xs text-gray-500">Login sebagai</p>
                <p class="font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>
            </div>

        </div>


        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- STATISTIK --}}
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
                    Setoran perlu diperiksa
                </p>
            </div>

            {{-- TOTAL SETORAN MENUNGGU --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total Setoran Menunggu
                </p>

                <h3 class="mt-2 text-3xl font-bold text-[#174b35]">
                    Rp{{ number_format((float) $pendingTotal, 0, ',', '.') }}
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Nominal yang perlu diverifikasi
                </p>
            </div>

            {{-- SETORAN DISETUJUI --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Setoran Disetujui
                </p>

                <h3 class="mt-2 text-3xl font-bold text-green-600">
                    {{ $approvedCount }}
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Invoice berstatus lunas
                </p>
            </div>

        </div>


        {{-- DAFTAR SETORAN --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800">
                    Daftar Setoran Komisi
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Daftar tagihan merchant yang telah mengirimkan bukti transfer.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-275 text-left text-sm">

                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Informasi Merchant</th>
                            <th class="px-6 py-4 font-semibold">Nomor Tagihan</th>
                            <th class="px-6 py-4 font-semibold">Periode</th>
                            <th class="px-6 py-4 font-semibold">Total Setoran</th>
                            <th class="px-6 py-4 font-semibold">Tanggal Transfer</th>
                            <th class="px-6 py-4 text-center font-semibold">Bukti Transfer</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($invoices as $invoice)

                            {{-- INFORMASI TAGIHAN --}}
                            <tr class="align-top transition hover:bg-gray-50">

                                {{-- MERCHANT --}}
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-800">
                                        {{ $invoice->merchant->business_name ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $invoice->merchant->user->name ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $invoice->merchant->user->email ?? '-' }}
                                    </p>
                                </td>

                                {{-- NOMOR INVOICE --}}
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-gray-800">
                                        {{ $invoice->invoice_number }}
                                    </p>

                                    <span class="mt-2 inline-block rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Menunggu Verifikasi
                                    </span>
                                </td>

                                {{-- PERIODE --}}
                                <td class="px-6 py-5 text-gray-600">
                                    {{ $invoice->period_start->format('d/m/Y') }}
                                    <span class="mx-1">-</span>
                                    {{ $invoice->period_end->format('d/m/Y') }}
                                </td>

                                {{-- TOTAL --}}
                                <td class="px-6 py-5 font-bold text-[#174b35]">
                                    Rp{{ number_format((float) $invoice->total_commission, 0, ',', '.') }}
                                </td>

                                {{-- TANGGAL TRANSFER --}}
                                <td class="px-6 py-5 text-gray-600">
                                    {{ $invoice->submitted_at?->format('d/m/Y H:i') ?? '-' }}

                                    @if ($invoice->payment_reference)
                                        <p class="mt-2 text-xs text-gray-400">
                                            Ref: {{ $invoice->payment_reference }}
                                        </p>
                                    @endif
                                </td>

                                {{-- BUKTI TRANSFER --}}
                                <td class="px-6 py-5 text-center">

                                    @if ($invoice->payment_proof)

                                        <a href="{{ asset('storage/' . $invoice->payment_proof) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center justify-center rounded-lg border border-[#174b35] px-3 py-2 text-xs font-semibold text-[#174b35] transition hover:bg-[#174b35] hover:text-white">

                                            Lihat Bukti

                                        </a>

                                    @else

                                        <span class="text-xs text-red-500">
                                            Tidak tersedia
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            {{-- DETAIL DAN TINDAKAN --}}
                            <tr>

                                <td colspan="6" class="bg-gray-50/70 px-6 py-6">

                                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                                        {{-- RINCIAN KOMISI --}}
                                        <div>

                                            <h4 class="mb-3 font-bold text-gray-800">
                                                Rincian Komisi
                                            </h4>

                                            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

                                                <table class="w-full text-left text-xs">

                                                    <thead class="bg-gray-50 text-gray-500">
                                                        <tr>
                                                            <th class="px-4 py-3">Kode Pesanan</th>
                                                            <th class="px-4 py-3">Penjualan</th>
                                                            <th class="px-4 py-3">Komisi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="divide-y divide-gray-100">

                                                        @forelse ($invoice->invoiceItems as $item)

                                                            <tr>
                                                                <td class="px-4 py-3 font-medium text-gray-700">
                                                                    {{ $item->commission->order?->order_code ?? '-' }}
                                                                </td>

                                                                <td class="px-4 py-3 text-gray-600">
                                                                    Rp{{ number_format((float) $item->commission->gross_amount, 0, ',', '.') }}
                                                                </td>

                                                                <td class="px-4 py-3 font-semibold text-[#174b35]">
                                                                    Rp{{ number_format((float) $item->commission->commission_amount, 0, ',', '.') }}
                                                                </td>
                                                            </tr>

                                                        @empty

                                                            <tr>
                                                                <td colspan="3" class="px-4 py-5 text-center text-gray-400">
                                                                    Tidak ada rincian komisi.
                                                                </td>
                                                            </tr>

                                                        @endforelse

                                                    </tbody>

                                                </table>

                                            </div>

                                            <div class="mt-3 flex justify-between rounded-xl bg-white p-4">
                                                <span class="text-sm font-semibold text-gray-600">
                                                    Total Setoran
                                                </span>

                                                <span class="text-sm font-bold text-[#174b35]">
                                                    Rp{{ number_format((float) $invoice->total_commission, 0, ',', '.') }}
                                                </span>
                                            </div>

                                        </div>


                                        {{-- TINDAKAN ADMIN --}}
                                        <div>

                                            <h4 class="mb-3 font-bold text-gray-800">
                                                Tindakan Verifikasi
                                            </h4>

                                            <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-5">

                                                <p class="text-sm leading-relaxed text-gray-600">
                                                    Pastikan bukti transfer valid dan nominal yang dibayarkan sesuai dengan total tagihan sebelum menyetujui setoran.
                                                </p>

                                                {{-- SETUJUI PEMBAYARAN --}}
                                                <form action="{{ route('admin.commissions.approve', $invoice->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menyetujui setoran komisi ini?')">

                                                    @csrf

                                                    <button type="submit"
                                                            class="w-full rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700">

                                                        Setujui Pembayaran

                                                    </button>

                                                </form>


                                                {{-- TOLAK PEMBAYARAN --}}
                                                <form action="{{ route('admin.commissions.reject', $invoice->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menolak bukti transfer ini?')">

                                                    @csrf

                                                    <div>
                                                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                                                            Alasan Penolakan
                                                        </label>

                                                        <textarea name="rejection_reason"
                                                                  rows="3"
                                                                  maxlength="1000"
                                                                  required
                                                                  placeholder="Contoh: Nominal transfer tidak sesuai dengan tagihan."
                                                                  class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"></textarea>
                                                    </div>

                                                    <button type="submit"
                                                            class="mt-3 w-full rounded-xl bg-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-600">

                                                        Tolak Pembayaran

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                                        <svg class="h-7 w-7 text-gray-400" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="1.6"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                                            <path d="M2 10H22"/>
                                        </svg>
                                    </div>

                                    <p class="mt-4 font-semibold text-gray-600">
                                        Belum ada setoran yang menunggu verifikasi.
                                    </p>

                                    <p class="mt-2 text-xs text-gray-400">
                                        Bukti transfer dari merchant akan muncul di halaman ini.
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
