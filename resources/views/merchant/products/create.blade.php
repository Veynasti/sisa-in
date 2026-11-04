```blade
@extends('layouts.merchant')

@section('page-title', 'Tambah Produk')
@section('page-description', 'Tambahkan produk surplus baru ke toko Anda.')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg px-4 py-2" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full border rounded-lg px-4 py-2">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Kategori</label>
                <select name="category_id" class="w-full border rounded-lg px-4 py-2" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Stok</label>
                <input type="number" name="stock" min="0" value="{{ old('stock', 1) }}"
                    class="w-full border rounded-lg px-4 py-2" required>
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Harga Normal (Rp)</label>
                <input type="number" name="normal_price" min="1" value="{{ old('normal_price') }}"
                    class="w-full border rounded-lg px-4 py-2" required>
                @error('normal_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Harga Surplus (Rp)</label>
                <input type="number" name="surplus_price" min="1" value="{{ old('surplus_price') }}"
                    class="w-full border rounded-lg px-4 py-2" required>
                @error('surplus_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Waktu Mulai Pickup</label>
                <input type="time" name="pickup_start" value="{{ old('pickup_start') }}"
                    class="w-full border rounded-lg px-4 py-2" required>
                @error('pickup_start')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Waktu Akhir Pickup</label>
                <input type="time" name="pickup_end" value="{{ old('pickup_end') }}"
                    class="w-full border rounded-lg px-4 py-2" required>
                @error('pickup_end')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-2">Foto Produk</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full border rounded-lg px-4 py-2">
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('merchant.products.index') }}"
                class="px-5 py-2 rounded-lg border text-gray-600">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 rounded-lg bg-green-700 text-white hover:bg-green-800">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
```
