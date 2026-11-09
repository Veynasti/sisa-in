@extends('layouts.merchant')

@section('title', 'Pengaturan QRIS - Sisa.in')
@section('page-title', 'Pengaturan QRIS')
@section('page-description', 'Kelola kode QRIS untuk menerima pembayaran dari customer.')

@section('content')

<div class="mx-auto max-w-5xl">

    {{-- HEADER --}}
    <div class="mb-7">
        <h2 class="text-xl font-bold text-gray-800">
            QRIS Toko Anda
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Unggah gambar QRIS agar customer dapat melakukan pembayaran secara digital.
        </p>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-100 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-100 p-4 text-sm text-red-700">
            <p class="mb-1 font-semibold">Gagal menyimpan QRIS:</p>

            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

        {{-- CURRENT QRIS --}}
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-gray-800">
                    QRIS Saat Ini
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Gambar yang akan ditampilkan kepada customer.
                </p>

                <div class="mt-5 flex min-h-64 items-center justify-center overflow-hidden rounded-xl border border-dashed border-gray-300 bg-gray-50 p-4">

                    @if ($merchant->qris_image)
                        <img
                            src="{{ asset('storage/' . $merchant->qris_image) }}"
                            alt="QRIS {{ $merchant->business_name }}"
                            class="max-h-72 w-full object-contain"
                        >
                    @else
                        <div class="text-center">
                            <div class="mb-3 text-5xl">📱</div>

                            <p class="font-semibold text-gray-500">
                                Belum Ada QRIS
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                Silakan unggah gambar QRIS toko Anda.
                            </p>
                        </div>
                    @endif

                </div>

                <div class="mt-4 rounded-xl bg-green-50 p-4">
                    <p class="text-sm font-semibold text-green-800">
                        {{ $merchant->business_name }}
                    </p>

                    <p class="mt-1 text-xs text-green-700">
                        QRIS ini digunakan untuk pembayaran pesanan di toko Anda.
                    </p>
                </div>

            </div>
        </div>

        {{-- UPLOAD FORM --}}
        <div class="lg:col-span-3">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-gray-800">
                    {{ $merchant->qris_image ? 'Ganti Gambar QRIS' : 'Upload Gambar QRIS' }}
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Pilih gambar QRIS resmi milik toko Anda.
                </p>

                <form
                    action="{{ route('merchant.qris.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-6"
                >

                    @csrf

                    {{-- FILE INPUT --}}
                    <label
                        for="qris_image"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center transition hover:border-[#174b35] hover:bg-green-50"
                    >

                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-[#174b35]">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="28" height="28"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>

                            </svg>

                        </div>

                        <span class="font-semibold text-gray-700">
                            Klik untuk memilih gambar QRIS
                        </span>

                        <span class="mt-2 text-xs text-gray-400">
                            Format JPG, JPEG, PNG, atau WEBP (maksimal 2 MB)
                        </span>

                        <input
                            type="file"
                            name="qris_image"
                            id="qris_image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="hidden"
                            required
                        >

                    </label>

                    {{-- FILE NAME --}}
                    <p id="file-name" class="mt-3 text-sm text-gray-500">
                        Belum ada gambar yang dipilih.
                    </p>

                    {{-- IMAGE PREVIEW --}}
                    <div id="preview-container" class="mt-5 hidden">

                        <p class="mb-2 text-sm font-semibold text-gray-700">
                            Preview Gambar
                        </p>

                        <div class="flex min-h-48 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-4">

                            <img
                                id="image-preview"
                                src=""
                                alt="Preview QRIS"
                                class="max-h-64 max-w-full object-contain"
                            >

                        </div>

                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <button
                        type="submit"
                        class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-[#174b35] px-5 py-3 font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#103b29] hover:shadow-md"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="18" height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>

                        </svg>

                        Simpan QRIS

                    </button>

                </form>

            </div>

            {{-- INFORMATION --}}
            <div class="mt-5 rounded-xl border border-blue-100 bg-blue-50 p-4">

                <div class="flex items-start gap-3">

                    <span class="text-xl">ℹ️</span>

                    <div>
                        <h4 class="text-sm font-semibold text-blue-800">
                            Informasi Penting
                        </h4>

                        <p class="mt-1 text-xs leading-relaxed text-blue-700">
                            Pastikan gambar QRIS jelas, tidak terpotong, dan dapat dipindai.
                            Gunakan QRIS resmi yang terdaftar atas nama toko Anda.
                            Jika mengganti gambar, gambar QRIS sebelumnya akan diganti dengan gambar baru.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- IMAGE PREVIEW SCRIPT --}}
<script>
    const input = document.getElementById('qris_image');
    const fileName = document.getElementById('file-name');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');

    let previewUrl = null;

    input.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Format file harus JPG, JPEG, PNG, atau WEBP.');
            this.value = '';
            fileName.textContent = 'Belum ada gambar yang dipilih.';
            previewContainer.classList.add('hidden');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2 MB.');
            this.value = '';
            fileName.textContent = 'Belum ada gambar yang dipilih.';
            previewContainer.classList.add('hidden');
            return;
        }

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }

        previewUrl = URL.createObjectURL(file);

        fileName.textContent = file.name;
        imagePreview.src = previewUrl;
        previewContainer.classList.remove('hidden');
    });
</script>

@endsection
