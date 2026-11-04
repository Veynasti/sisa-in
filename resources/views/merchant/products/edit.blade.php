
@extends('layouts.merchant')

@section('title', 'Edit Produk - Sisa.in')

@section('page-title', 'Edit Produk')

@section('page-description', 'Perbarui informasi produk surplus makanan kamu.')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

    {{-- Notifikasi error --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <p class="font-semibold text-red-700 mb-2">
                Periksa kembali data produk:
            </p>

            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('merchant.products.update', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nama Produk --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Produk
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring-green-500"
                >
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                </label>

                <select
                    name="category_id"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
                    <option value="">Pilih Kategori</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Stok --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Stok Produk
                </label>

                <input
                    type="number"
                    name="stock"
                    value="{{ old('stock', $product->stock) }}"
                    min="0"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
            </div>

            {{-- Harga Normal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Harga Normal (Rp)
                </label>

                <input
                    type="number"
                    name="normal_price"
                    value="{{ old('normal_price', $product->normal_price) }}"
                    min="1"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
            </div>

            {{-- Harga Surplus --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Harga Surplus (Rp)
                </label>

                <input
                    type="number"
                    name="surplus_price"
                    value="{{ old('surplus_price', $product->surplus_price) }}"
                    min="1"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
            </div>

            {{-- Waktu Mulai Pickup --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jam Mulai Pickup
                </label>

                <input
                    type="time"
                    name="pickup_start"
                    value="{{ old('pickup_start', substr($product->pickup_start, 0, 5)) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
            </div>

            {{-- Waktu Selesai Pickup --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jam Selesai Pickup
                </label>

                <input
                    type="time"
                    name="pickup_end"
                    value="{{ old('pickup_end', substr($product->pickup_end, 0, 5)) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Produk
                </label>

                <select
                    name="status"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >
                    <option value="available"
                        {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>
                        Tersedia
                    </option>

                    <option value="unavailable"
                        {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>
                        Tidak Tersedia
                    </option>
                </select>
            </div>

            {{-- Foto Produk --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Produk
                </label>

                @if ($product->photo)
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Foto saat ini:</p>

                        <img
                            src="{{ asset('storage/' . $product->photo) }}"
                            alt="{{ $product->name }}"
                            class="w-40 h-32 object-cover rounded-lg border"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >

                <p class="text-xs text-gray-500 mt-2">
                    Kosongkan jika tidak ingin mengganti foto. Maksimal 2 MB.
                </p>
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Produk
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                >{{ old('description', $product->description) }}</textarea>
            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">

            <a
                href="{{ route('merchant.products.index') }}"
                class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-5 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>
</div>

@endsection
