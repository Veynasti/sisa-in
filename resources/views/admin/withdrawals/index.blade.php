    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Keuntungan Sisa.in - Admin Panel</title>
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
                class="flex items-center gap-3 rounded-xl bg-white/15 px-4 py-3 text-sm font-semibold text-white">

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
                        Admin / Keuntungan Sisa.in
                    </p>

                    <h2 class="mt-1 text-2xl font-bold text-gray-800 sm:text-3xl">
                        Keuntungan Sisa.in
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Pantau keuntungan platform dan catat penarikan dana ke rekening pemilik.
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


            {{-- RINGKASAN KEUNTUNGAN --}}
            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

                {{-- TOTAL KOMISI DITERIMA --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-500">
                            Total Komisi Diterima
                        </p>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="mt-4 text-2xl font-bold text-gray-800">
                        Rp{{ number_format((float) $totalCommission, 0, ',', '.') }}
                    </h3>

                    <p class="mt-2 text-xs text-gray-400">
                        Akumulasi setoran merchant yang telah disetujui
                    </p>
                </div>


                {{-- TOTAL PENARIKAN --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-500">
                            Total Sudah Ditarik
                        </p>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 19V5"/>
                                <path d="M5 12l7-7 7 7"/>
                                <path d="M4 21h16"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="mt-4 text-2xl font-bold text-gray-800">
                        Rp{{ number_format((float) $totalWithdrawn, 0, ',', '.') }}
                    </h3>

                    <p class="mt-2 text-xs text-gray-400">
                        Akumulasi seluruh transaksi penarikan
                    </p>
                </div>


                {{-- SALDO TERSEDIA --}}
                <div class="rounded-2xl border border-green-100 bg-green-50 p-6 shadow-sm sm:col-span-2 xl:col-span-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-green-800">
                            Saldo Tersedia
                        </p>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-green-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 7h18v13H3z"/>
                                <path d="M3 7l2-4h14l2 4"/>
                                <path d="M16 13h5"/>
                                <circle cx="16" cy="13" r="1"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="mt-4 text-2xl font-bold text-green-800">
                        Rp{{ number_format((float) $availableBalance, 0, ',', '.') }}
                    </h3>

                    <p class="mt-2 text-xs text-green-700">
                        Keuntungan yang masih dapat ditarik
                    </p>
                </div>

            </div>


            {{-- FORM PENARIKAN --}}
            <div class="mb-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800">
                        Catat Penarikan Keuntungan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Isi informasi penarikan setelah transfer ke rekening pemilik platform dilakukan.
                    </p>
                </div>

                <form action="{{ route('admin.withdrawals.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6 p-6">

                    @csrf

                    {{-- SALDO TERSEDIA --}}
                    <div class="rounded-xl border border-green-100 bg-green-50 p-4">
                        <p class="text-xs font-medium text-green-700">
                            Saldo yang dapat ditarik
                        </p>

                        <p class="mt-1 text-xl font-bold text-green-800">
                            Rp{{ number_format((float) $availableBalance, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- NOMINAL --}}
                        <div>
                            <label for="amount" class="mb-2 block text-sm font-semibold text-gray-700">
                                Nominal Penarikan
                            </label>

                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">
                                    Rp
                                </span>

                                <input type="number"
                                    id="amount"
                                    name="amount"
                                    min="1"
                                    max="{{ max(0, (float) $availableBalance) }}"
                                    step="1"
                                    value="{{ old('amount') }}"
                                    required
                                    {{ (float) $availableBalance <= 0 ? 'disabled' : '' }}
                                    placeholder="Masukkan nominal penarikan"
                                    class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-green-100 disabled:cursor-not-allowed disabled:bg-gray-100">

                            </div>
                        </div>


                        {{-- TANGGAL --}}
                        <div>
                            <label for="withdrawal_date" class="mb-2 block text-sm font-semibold text-gray-700">
                                Tanggal Penarikan
                            </label>

                            <input type="date"
                                id="withdrawal_date"
                                name="withdrawal_date"
                                value="{{ old('withdrawal_date', now()->format('Y-m-d')) }}"
                                max="{{ now()->format('Y-m-d') }}"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-green-100">
                        </div>

                        {{-- REKENING TUJUAN --}}
                        <div>
                            <label for="bank_name" class="mb-2 block text-sm font-semibold text-gray-700">
                                Nama Bank
                            </label>

                            <select id="bank_name"
                                    name="bank_name"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-green-100">

                                <option value="">Pilih Bank</option>

                                @php
                                    $banks = [
                                        'BCA',
                                        'BRI',
                                        'BNI',
                                        'Bank Mandiri',
                                        'BSI',
                                        'BTN',
                                        'CIMB Niaga',
                                        'Danamon',
                                        'Bank Permata',
                                        'OCBC',
                                        'Maybank',
                                        'Bank Mega',
                                        'Panin Bank',
                                        'Bank Jago',
                                        'SeaBank',
                                        'Bank Neo Commerce',
                                        'Bank lainnya',
                                    ];
                                @endphp

                                @foreach ($banks as $bank)
                                    <option value="{{ $bank }}"
                                        {{ old('bank_name') === $bank ? 'selected' : '' }}>
                                        {{ $bank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NOMOR REKENING --}}
                        <div>
                            <label for="destination_account" class="mb-2 block text-sm font-semibold text-gray-700">
                                Nomor Rekening Tujuan
                            </label>

                            <input type="text"
                                id="destination_account"
                                name="destination_account"
                                value="{{ old('destination_account') }}"
                                maxlength="50"
                                inputmode="numeric"
                                pattern="[0-9]+"
                                required
                                placeholder="Masukkan nomor rekening"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-green-100">
                        </div>

                        {{-- NAMA PEMILIK --}}
                        <div>
                            <label for="account_holder" class="mb-2 block text-sm font-semibold text-gray-700">
                                Nama Pemilik Rekening
                            </label>

                            <input type="text"
                                id="account_holder"
                                name="account_holder"
                                value="{{ old('account_holder') }}"
                                maxlength="255"
                                required
                                placeholder="Masukkan nama pemilik rekening"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-green-100">
                        </div>

                        {{-- KETERANGAN --}}
                        <div class="md:col-span-2">
                            <label for="description" class="mb-2 block text-sm font-semibold text-gray-700">
                                Keterangan
                                <span class="font-normal text-gray-400">(Opsional)</span>
                            </label>

                            <textarea id="description"
                                    name="description"
                                    rows="3"
                                    maxlength="1000"
                                    placeholder="Contoh: Penarikan keuntungan komisi periode November 2026."
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-green-100">{{ old('description') }}</textarea>
                        </div>


                        {{-- BUKTI TRANSFER --}}
                        <div class="md:col-span-2">
                            <label for="proof" class="mb-2 block text-sm font-semibold text-gray-700">
                                Bukti Transfer
                            </label>

                            <input type="file"
                                id="proof"
                                name="proof"
                                accept=".jpg,.jpeg,.png,.pdf"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-600 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-green-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-green-700 hover:file:bg-green-100">

                            <p class="mt-2 text-xs text-gray-400">
                                Format JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.
                            </p>
                        </div>

                    </div>


                    {{-- TOMBOL SIMPAN --}}
                    <div class="flex flex-col justify-end gap-3 border-t border-gray-100 pt-5 sm:flex-row">

                        <button type="reset"
                                class="rounded-xl border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                            Reset Form
                        </button>

                        <button type="submit"
                                {{ (float) $availableBalance <= 0 ? 'disabled' : '' }}
                                onclick="return confirm('Pastikan transfer sudah dilakukan dan data penarikan sudah benar. Lanjutkan pencatatan?')"
                                class="rounded-xl bg-[#174b35] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#103b29] disabled:cursor-not-allowed disabled:bg-gray-400">
                            Simpan Penarikan
                        </button>

                    </div>

                    @if ((float) $availableBalance <= 0)
                        <p class="text-right text-xs text-red-500">
                            Belum ada saldo keuntungan yang tersedia untuk ditarik.
                        </p>
                    @endif

                </form>

            </div>


            {{-- RIWAYAT PENARIKAN --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800">
                        Riwayat Penarikan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Seluruh transaksi penarikan keuntungan yang pernah dicatat.
                    </p>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full min-w-225 text-left text-sm">

                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Nomor Penarikan</th>
                                <th class="px-6 py-4 font-semibold">Tanggal</th>
                                <th class="px-6 py-4 font-semibold">Nominal</th>
                                <th class="px-6 py-4 font-semibold">Rekening Tujuan</th>
                                <th class="px-6 py-4 font-semibold">Dicatat Oleh</th>
                                <th class="px-6 py-4 text-center font-semibold">Bukti Transfer</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($withdrawals as $withdrawal)

                                <tr class="transition hover:bg-gray-50">

                                    {{-- NOMOR --}}
                                    <td class="px-6 py-5">
                                        <p class="font-semibold text-gray-800">
                                            {{ $withdrawal->withdrawal_number }}
                                        </p>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $withdrawal->withdrawal_date?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    {{-- NOMINAL --}}
                                    <td class="px-6 py-5 font-bold text-[#174b35]">
                                        Rp{{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                                    </td>

                                    {{-- REKENING --}}
                                    <td class="px-6 py-5">
                                        <p class="font-semibold text-gray-700">
                                            {{ $withdrawal->destination_account }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $withdrawal->account_holder }}
                                        </p>
                                    </td>

                                    {{-- ADMIN --}}
                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $withdrawal->admin->name ?? '-' }}
                                    </td>

                                    {{-- BUKTI --}}
                                    <td class="px-6 py-5 text-center">

                                        @if ($withdrawal->proof)

                                            <a href="{{ asset('storage/' . $withdrawal->proof) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center rounded-lg border border-[#174b35] px-3 py-2 text-xs font-semibold text-[#174b35] transition hover:bg-[#174b35] hover:text-white">

                                                Lihat Bukti

                                            </a>

                                        @else

                                            <span class="text-xs text-gray-400">
                                                Tidak tersedia
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                                {{-- KETERANGAN --}}
                                @if ($withdrawal->description)
                                    <tr>
                                        <td colspan="6" class="bg-gray-50/70 px-6 py-3">
                                            <p class="text-xs text-gray-500">
                                                <span class="font-semibold text-gray-700">Keterangan:</span>
                                                {{ $withdrawal->description }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                                            <svg class="h-7 w-7 text-gray-400" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.6"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 17l6-6 4 4 8-9"/>
                                                <path d="M15 6h6v6"/>
                                            </svg>
                                        </div>

                                        <p class="mt-4 font-semibold text-gray-600">
                                            Belum ada riwayat penarikan.
                                        </p>

                                        <p class="mt-2 text-xs text-gray-400">
                                            Transaksi penarikan yang berhasil dicatat akan muncul di sini.
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
