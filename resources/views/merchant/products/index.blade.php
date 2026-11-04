
@extends('layouts.merchant')

@section('title', 'Produk Saya - Sisa.in')
@section('page-title', 'Produk Saya')
@section('page-description', 'Kelola produk surplus makanan yang kamu jual.')

@section('content')

<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Produk Saya</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola produk surplus makanan yang kamu jual.
                </p>
            </div>

            <button
                type="button"
                onclick="openProductModal()"
                class="inline-flex items-center justify-center rounded-lg bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                + Tambah Produk
            </button>
        </div>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi validasi --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="mb-2 font-semibold">Periksa kembali data produk:</p>
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Ringkasan Produk --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ $products->count() }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Produk Tersedia</p>
                <p class="mt-2 text-2xl font-bold text-green-600">
                    {{ $products->where('status', 'available')->count() }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Stok Habis</p>
                <p class="mt-2 text-2xl font-bold text-red-500">
                    {{ $products->where('stock', 0)->count() }}
                </p>
            </div>

        </div>

        {{-- Daftar Produk --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-6 py-5">
                <h2 class="font-semibold text-gray-800">Daftar Produk</h2>
            </div>

            @if ($products->isEmpty())

                <div class="px-6 py-16 text-center">
                    <div class="mb-3 text-4xl">🍱</div>

                    <h3 class="font-semibold text-gray-800">
                        Belum Ada Produk
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Mulai tambahkan produk surplus makanan dari tokomu.
                    </p>

                    <button
                        type="button"
                        onclick="openProductModal()"
                        class="mt-5 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                        Tambah Produk Pertama
                    </button>
                </div>

            @else

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">

                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-medium">Produk</th>
                                <th class="px-6 py-4 font-medium">Kategori</th>
                                <th class="px-6 py-4 font-medium">Harga Normal</th>
                                <th class="px-6 py-4 font-medium">Harga Surplus</th>
                                <th class="px-6 py-4 font-medium">Stok</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 text-center font-medium">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50">

                                    {{-- Informasi Produk --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            @if ($product->photo)
                                                <img
                                                    src="{{ asset('storage/' . $product->photo) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-12 w-12 rounded-lg object-cover">
                                            @else
                                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 text-xl">
                                                    🍱
                                                </div>
                                            @endif

                                            <span class="font-semibold text-gray-800">
                                                {{ $product->name }}
                                            </span>

                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $product->category->name ?? '-' }}
                                    </td>

                                    {{-- Harga Normal --}}
                                    <td class="px-6 py-4 text-gray-500">
                                        Rp{{ number_format($product->normal_price, 0, ',', '.') }}
                                    </td>

                                    {{-- Harga Surplus --}}
                                    <td class="px-6 py-4 font-semibold text-green-600">
                                        Rp{{ number_format($product->surplus_price, 0, ',', '.') }}
                                    </td>

                                    {{-- Stok --}}
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $product->stock }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        @if ($product->status === 'available' && $product->stock > 0)
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-3">

                                            {{-- Tombol Edit --}}
                                            <button
                                                type="button"
                                                onclick="openEditProductModal(this)"
                                                data-id="{{ $product->id }}"
                                                data-update-url="{{ route('merchant.products.update', $product->id) }}"
                                                data-name="{{ $product->name }}"
                                                data-description="{{ $product->description }}"
                                                data-category="{{ $product->category_id }}"
                                                data-stock="{{ $product->stock }}"
                                                data-normal-price="{{ $product->normal_price }}"
                                                data-surplus-price="{{ $product->surplus_price }}"
                                                data-pickup-start="{{ substr($product->pickup_start, 0, 5) }}"
                                                data-pickup-end="{{ substr($product->pickup_end, 0, 5) }}"
                                                data-status="{{ $product->status }}"
                                                data-photo="{{ $product->photo ? asset('storage/' . $product->photo) : '' }}"
                                                class="font-medium text-blue-600 hover:text-blue-800">
                                                Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <button
                                                type="button"
                                                onclick="openDeleteModal(
                                                    '{{ $product->id }}',
                                                    '{{ addslashes($product->name) }}',
                                                    '{{ route('merchant.products.destroy', $product->id) }}'
                                                )"
                                                class="font-medium text-red-600 hover:text-red-800"
                                            >
                                                Hapus
                                            </button>

                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            @endif

        </div>

    </div>
</div>


{{-- ==================================================
     MODAL TAMBAH PRODUK
================================================== --}}

<dialog
    id="productModal"
    class="m-auto w-[calc(100%-2rem)] max-w-2xl rounded-2xl border-0 p-0 shadow-2xl backdrop:bg-black/50">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Tambah Produk Baru
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Lengkapi informasi produk surplus tokomu.
            </p>
        </div>

        <button
            type="button"
            onclick="closeProductModal()"
            class="rounded-lg px-3 py-2 text-gray-500 hover:bg-gray-100">
            ✕
        </button>

    </div>

    {{-- Form Tambah --}}
    <form
        action="{{ route('merchant.products.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="form_type" value="add">

        <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

            {{-- Nama Produk --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Produk
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('form_type') === 'add' ? old('name') : '' }}"
                    placeholder="Contoh: Nasi Goreng"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                    required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Deskripsi Produk
                </label>
                <textarea
                    name="description"
                    rows="3"
                    placeholder="Jelaskan kondisi dan informasi produk..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">{{ old('form_type') === 'add' ? old('description') : '' }}</textarea>
            </div>

            {{-- Kategori dan Stok --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Kategori
                    </label>
                    <select
                        name="category_id"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">

                        <option value="">Pilih Kategori</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('form_type') === 'add' && old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Stok Produk
                    </label>
                    <input
                        type="number"
                        name="stock"
                        min="0"
                        value="{{ old('form_type') === 'add' ? old('stock', 1) : 1 }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Harga --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Harga Normal (Rp)
                    </label>
                    <input
                        type="number"
                        name="normal_price"
                        min="1"
                        value="{{ old('form_type') === 'add' ? old('normal_price') : '' }}"
                        placeholder="15000"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Harga Surplus (Rp)
                    </label>
                    <input
                        type="number"
                        name="surplus_price"
                        min="1"
                        value="{{ old('form_type') === 'add' ? old('surplus_price') : '' }}"
                        placeholder="10000"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Waktu Pickup --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Waktu Mulai Pickup
                    </label>
                    <input
                        type="time"
                        name="pickup_start"
                        value="{{ old('form_type') === 'add' ? old('pickup_start') : '' }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Waktu Akhir Pickup
                    </label>
                    <input
                        type="time"
                        name="pickup_end"
                        value="{{ old('form_type') === 'add' ? old('pickup_end') : '' }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Status --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Status Produk
                </label>
                <select
                    name="status"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">
                    <option value="available"
                        {{ old('form_type') === 'add' && old('status', 'available') === 'available' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="unavailable"
                        {{ old('form_type') === 'add' && old('status') === 'unavailable' ? 'selected' : '' }}>
                        Tidak Tersedia
                    </option>
                </select>
            </div>

            {{-- Foto --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Foto Produk
                </label>
                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">
                <p class="mt-2 text-xs text-gray-500">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </p>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 border-t border-gray-100 px-6 py-5">

            <button
                type="button"
                onclick="closeProductModal()"
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                Batal
            </button>

            <button
                type="submit"
                class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                Simpan Produk
            </button>

        </div>

    </form>
</dialog>


{{-- ==================================================
     MODAL EDIT PRODUK
================================================== --}}

<dialog
    id="editProductModal"
    class="m-auto w-[calc(100%-2rem)] max-w-2xl rounded-2xl border-0 p-0 shadow-2xl backdrop:bg-black/50">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Edit Produk
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi produk tokomu.
            </p>
        </div>

        <button
            type="button"
            onclick="closeEditProductModal()"
            class="rounded-lg px-3 py-2 text-gray-500 hover:bg-gray-100">
            ✕
        </button>

    </div>

    {{-- Form Edit --}}
    <form
        id="editProductForm"
        action=""
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <input type="hidden" name="form_type" value="edit">
        <input type="hidden" name="product_id" id="edit_product_id">

        <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

            {{-- Nama Produk --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Produk
                </label>
                <input
                    type="text"
                    name="name"
                    id="edit_name"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Deskripsi Produk
                </label>
                <textarea
                    name="description"
                    id="edit_description"
                    rows="3"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"></textarea>
            </div>

            {{-- Kategori dan Stok --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Kategori
                    </label>
                    <select
                        name="category_id"
                        id="edit_category_id"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">

                        <option value="">Pilih Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Stok Produk
                    </label>
                    <input
                        type="number"
                        name="stock"
                        id="edit_stock"
                        min="0"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Harga --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Harga Normal (Rp)
                    </label>
                    <input
                        type="number"
                        name="normal_price"
                        id="edit_normal_price"
                        min="1"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Harga Surplus (Rp)
                    </label>
                    <input
                        type="number"
                        name="surplus_price"
                        id="edit_surplus_price"
                        min="1"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Waktu Pickup --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Waktu Mulai Pickup
                    </label>
                    <input
                        type="time"
                        name="pickup_start"
                        id="edit_pickup_start"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Waktu Akhir Pickup
                    </label>
                    <input
                        type="time"
                        name="pickup_end"
                        id="edit_pickup_end"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">
                </div>

            </div>

            {{-- Status --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Status Produk
                </label>
                <select
                    name="status"
                    id="edit_status"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">

                    <option value="available">Tersedia</option>
                    <option value="unavailable">Tidak Tersedia</option>

                </select>
            </div>

            {{-- Foto --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Foto Produk Saat Ini
                </label>

                <img
                    id="edit_photo_preview"
                    src=""
                    alt="Foto produk"
                    class="mb-3 hidden h-32 w-40 rounded-lg border object-cover">

                <input
                    type="file"
                    name="photo"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <p class="mt-2 text-xs text-gray-500">
                    Kosongkan jika tidak ingin mengganti foto. Maksimal 2 MB.
                </p>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 border-t border-gray-100 px-6 py-5">

            <button
                type="button"
                onclick="closeEditProductModal()"
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">
                Batal
            </button>

            <button
                type="submit"
                class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                Simpan Perubahan
            </button>

        </div>

    </form>
</dialog>

{{-- Modal Konfirmasi Hapus --}}
<dialog
    id="deleteProductModal"
    class="m-auto w-full max-w-md rounded-2xl bg-white p-0 shadow-xl backdrop:bg-black/50"
>
    <div class="p-6">

        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <svg
                    class="h-6 w-6 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 7h12M10 11v6m4-6v6M9 7V4h6v3m-9 0 1 14h10l1-14"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Hapus Produk?
                </h2>
                <p class="text-sm text-gray-500">
                    Konfirmasi penghapusan produk
                </p>
            </div>
        </div>

        <p class="mb-6 text-sm text-gray-600">
            Apakah kamu yakin ingin menghapus produk
            <span id="deleteProductName" class="font-semibold text-gray-900"></span>?
            Produk yang dihapus tidak dapat dikembalikan.
        </p>

        <div class="flex justify-end gap-3">
            <button
                type="button"
                onclick="closeDeleteModal()"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Batal
            </button>

            <form id="deleteProductForm" method="POST">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                >
                    Ya, Hapus
                </button>
            </form>
        </div>

    </div>
</dialog>
{{-- ==================================================
     JAVASCRIPT MODAL
================================================== --}}

<script>
    // ==========================================
    // MODAL TAMBAH PRODUK
    // ==========================================

    function openProductModal() {
        document.getElementById('productModal').showModal();
    }

    function closeProductModal() {
        document.getElementById('productModal').close();
    }


    // ==========================================
    // MODAL EDIT PRODUK
    // ==========================================

    function openEditProductModal(button) {
        const modal = document.getElementById('editProductModal');
        const form = document.getElementById('editProductForm');

        // Mengatur URL update
        form.action = button.dataset.updateUrl;

        // Mengisi ID produk
        document.getElementById('edit_product_id').value = button.dataset.id;

        // Mengisi data produk
        document.getElementById('edit_name').value = button.dataset.name;
        document.getElementById('edit_description').value = button.dataset.description || '';
        document.getElementById('edit_category_id').value = button.dataset.category;
        document.getElementById('edit_stock').value = button.dataset.stock;
        document.getElementById('edit_normal_price').value = button.dataset.normalPrice;
        document.getElementById('edit_surplus_price').value = button.dataset.surplusPrice;
        document.getElementById('edit_pickup_start').value = button.dataset.pickupStart;
        document.getElementById('edit_pickup_end').value = button.dataset.pickupEnd;
        document.getElementById('edit_status').value = button.dataset.status;

        // Menampilkan foto produk
        const photo = document.getElementById('edit_photo_preview');

        if (button.dataset.photo) {
            photo.src = button.dataset.photo;
            photo.classList.remove('hidden');
        } else {
            photo.src = '';
            photo.classList.add('hidden');
        }

        modal.showModal();
    }

    function closeEditProductModal() {
        document.getElementById('editProductModal').close();
    }


    // ==========================================
    // MENUTUP MODAL KETIKA KLIK AREA LUAR
    // ==========================================

    document.getElementById('productModal').addEventListener('click', function(event) {
        if (event.target === this) {
            this.close();
        }
    });

    document.getElementById('editProductModal').addEventListener('click', function(event) {
        if (event.target === this) {
            this.close();
        }
    });


    // ==========================================
    // MEMBUKA KEMBALI MODAL JIKA VALIDASI GAGAL
    // ==========================================

    @if ($errors->any() && old('form_type') === 'add')
        openProductModal();
    @endif

    @if ($errors->any() && old('form_type') === 'edit')
        const failedProductButton = document.querySelector(
            '[data-id="{{ old('product_id') }}"]'
        );

        if (failedProductButton) {
            openEditProductModal(failedProductButton);

            // Mengembalikan input yang sebelumnya diisi
            document.getElementById('edit_name').value = @json(old('name'));
            document.getElementById('edit_description').value = @json(old('description'));
            document.getElementById('edit_category_id').value = @json(old('category_id'));
            document.getElementById('edit_stock').value = @json(old('stock'));
            document.getElementById('edit_normal_price').value = @json(old('normal_price'));
            document.getElementById('edit_surplus_price').value = @json(old('surplus_price'));
            document.getElementById('edit_pickup_start').value = @json(old('pickup_start'));
            document.getElementById('edit_pickup_end').value = @json(old('pickup_end'));
            document.getElementById('edit_status').value = @json(old('status'));
        }
    @endif

    //Modal delete
    function openDeleteModal(id, name, url) {
        document.getElementById('deleteProductName').textContent = name;

        document.getElementById('deleteProductForm').action = url;

        document.getElementById('deleteProductModal').showModal();
    }

    function closeDeleteModal() {
        document.getElementById('deleteProductModal').close();
    }

    document.getElementById('deleteProductModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });

</script>

@endsection
