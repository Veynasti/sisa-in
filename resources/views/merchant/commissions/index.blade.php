@extends('layouts.merchant')

@section('title', 'Setoran Komisi - Sisa.in')
@section('page-title', 'Setoran Komisi')
@section('page-description', 'Kelola tagihan dan pembayaran komisi platform Sisa.in.')

@section('content')

<div class="space-y-6">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">Terjadi kesalahan:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- RINGKASAN KOMISI --}}
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Komisi Belum Ditagihkan
            </p>

            <h2 class="mt-3 text-3xl font-bold text-[#174b35]">
                Rp{{ number_format((float) $pendingTotal, 0, ',', '.') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                {{ $pendingCommissions->count() }} transaksi belum masuk tagihan.
            </p>

            @if ($pendingCommissions->isNotEmpty())
                <form action="{{ route('merchant.commissions.generate') }}"
                      method="POST"
                      class="mt-5">
                    @csrf

                    <button type="submit"
                            onclick="return confirm('Buat tagihan dari seluruh komisi yang belum ditagihkan?')"
                            class="rounded-xl bg-[#174b35] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#103b29]">
                        Buat Tagihan
                    </button>
                </form>
            @else
                <div class="mt-5 inline-block rounded-lg bg-gray-100 px-4 py-2 text-sm text-gray-500">
                    Belum ada komisi baru
                </div>
            @endif
        </div>


        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Total Tagihan
            </p>

            <h2 class="mt-3 text-3xl font-bold text-[#174b35]">
                Rp{{ number_format((float) $invoices->where('status', '!=', 'paid')->sum('total_commission'), 0, ',', '.') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Akumulasi tagihan yang belum berstatus lunas.
            </p>
        </div>

    </div>


    {{-- KOMISI BELUM DITAGIHKAN --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

        <div class="border-b border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800">
                Komisi Belum Ditagihkan
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Daftar transaksi yang komisinya belum dimasukkan ke invoice.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode Pesanan</th>
                        <th class="px-6 py-4 font-semibold">Penjualan</th>
                        <th class="px-6 py-4 font-semibold">Komisi 5%</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($pendingCommissions as $commission)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $commission->order?->order_code ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                Rp{{ number_format((float) $commission->gross_amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-[#174b35]">
                                Rp{{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $commission->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                Belum ada komisi yang perlu ditagihkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>


    {{-- RIWAYAT TAGIHAN --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

        <div class="border-b border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800">
                Riwayat Tagihan Komisi
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Semua tagihan komisi yang pernah dibuat.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nomor Tagihan</th>
                        <th class="px-6 py-4 font-semibold">Periode</th>
                        <th class="px-6 py-4 font-semibold">Total</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Dibuat</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($invoices as $invoice)

                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $invoice->invoice_number }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $invoice->period_start->format('d/m/Y') }}
                                -
                                {{ $invoice->period_end->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-[#174b35]">
                                Rp{{ number_format((float) $invoice->total_commission, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">

                                @if ($invoice->status === 'paid')
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Lunas
                                    </span>

                                @elseif ($invoice->status === 'pending_verification')
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Menunggu Verifikasi
                                    </span>

                                @elseif ($invoice->status === 'overdue')
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Terlambat
                                    </span>

                                @else
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                        Belum Dibayar
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $invoice->created_at->format('d/m/Y') }}
                            </td>
                        </tr>


                        {{-- DETAIL DAN UPLOAD BUKTI TRANSFER --}}
                        <tr>
                            <td colspan="5" class="bg-gray-50/70 px-6 py-6">

                                <div class="max-w-3xl space-y-4">

                                    <div>
                                        <h4 class="font-semibold text-gray-800">
                                            Pembayaran Tagihan
                                        </h4>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Tagihan {{ $invoice->invoice_number }}
                                            sebesar
                                            <span class="font-semibold text-[#174b35]">
                                                Rp{{ number_format((float) $invoice->total_commission, 0, ',', '.') }}
                                            </span>
                                        </p>
                                    </div>


                                    {{-- STATUS MENUNGGU VERIFIKASI --}}
                                    @if ($invoice->status === 'pending_verification')

                                        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4">

                                            <div class="flex items-center gap-2 text-sm font-semibold text-yellow-800">
                                                <span>⏳</span>
                                                Bukti Transfer Sedang Diperiksa
                                            </div>

                                            <p class="mt-2 text-sm text-yellow-700">
                                                Bukti transfer telah dikirim pada
                                                {{ $invoice->submitted_at?->format('d/m/Y H:i') ?? '-' }}.
                                                Silakan menunggu verifikasi Admin.
                                            </p>

                                            @if ($invoice->payment_reference)
                                                <p class="mt-2 text-sm text-yellow-700">
                                                    Nomor referensi:
                                                    {{ $invoice->payment_reference }}
                                                </p>
                                            @endif

                                            @if ($invoice->payment_proof)
                                                <a href="{{ asset('storage/' . $invoice->payment_proof) }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#174b35] underline">
                                                    Lihat Bukti Transfer
                                                </a>
                                            @endif

                                        </div>


                                    {{-- STATUS LUNAS --}}
                                    @elseif ($invoice->status === 'paid')

                                        <div class="rounded-xl border border-green-200 bg-green-50 p-4">

                                            <p class="text-sm font-semibold text-green-800">
                                                ✓ Pembayaran Telah Diverifikasi
                                            </p>

                                            <p class="mt-2 text-sm text-green-700">
                                                Tagihan ini sudah dinyatakan lunas oleh Admin.
                                            </p>

                                            @if ($invoice->verified_at)
                                                <p class="mt-1 text-sm text-green-700">
                                                    Tanggal verifikasi:
                                                    {{ $invoice->verified_at->format('d/m/Y H:i') }}
                                                </p>
                                            @endif

                                        </div>


                                    {{-- FORM UPLOAD BUKTI --}}
                                    @else

                                        @if ($invoice->rejection_reason)
                                            <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                                                <p class="text-sm font-semibold text-red-800">
                                                    Bukti Transfer Ditolak Admin
                                                </p>

                                                <p class="mt-2 text-sm text-red-700">
                                                    Alasan penolakan:
                                                    {{ $invoice->rejection_reason }}
                                                </p>

                                                <p class="mt-2 text-xs text-red-600">
                                                    Silakan periksa kembali bukti transfer dan unggah ulang.
                                                </p>

                                            </div>
                                        @endif


                                        <form action="{{ route('merchant.commissions.upload-proof', $invoice->id) }}"
                                              method="POST"
                                              enctype="multipart/form-data"
                                              class="rounded-xl border border-gray-200 bg-white p-5">

                                            @csrf

                                            <div class="space-y-4">

                                                <div>
                                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                                        Bukti Transfer
                                                    </label>

                                                    <input type="file"
                                                           name="payment_proof"
                                                           accept=".jpg,.jpeg,.png,.pdf"
                                                           required
                                                           class="block w-full rounded-xl border border-gray-300 p-3 text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-[#174b35] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#103b29]">

                                                    <p class="mt-2 text-xs text-gray-500">
                                                        Format JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.
                                                    </p>
                                                </div>


                                                <div>
                                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                                        Nomor Referensi Transfer
                                                        <span class="font-normal text-gray-400">(Opsional)</span>
                                                    </label>

                                                    <input type="text"
                                                           name="payment_reference"
                                                           value="{{ old('payment_reference') }}"
                                                           maxlength="255"
                                                           placeholder="Masukkan nomor referensi transfer"
                                                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#174b35] focus:ring-2 focus:ring-[#174b35]/10">
                                                </div>


                                                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 pt-4">

                                                    <p class="text-xs text-gray-500">
                                                        Pastikan nominal transfer sesuai dengan total tagihan.
                                                    </p>

                                                    <button type="submit"
                                                            onclick="return confirm('Kirim bukti transfer untuk diverifikasi Admin?')"
                                                            class="rounded-xl bg-[#174b35] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#103b29]">

                                                        {{ $invoice->rejection_reason ? 'Unggah Ulang Bukti' : 'Kirim Bukti Transfer' }}

                                                    </button>

                                                </div>

                                            </div>

                                        </form>

                                    @endif

                                </div>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                Belum ada tagihan komisi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
