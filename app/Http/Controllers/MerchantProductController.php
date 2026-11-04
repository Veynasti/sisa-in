<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MerchantProductController extends Controller
{
    /**
     * Menampilkan seluruh produk milik merchant yang login.
     */
    public function index()
    {
        $merchant = auth()->user()->merchant;

        $products = $merchant->products()
            ->with('category')
            ->latest()
            ->get();

        $categories = \App\Models\Category::all();

        return view('merchant.products.index', compact(
            'products',
            'categories'
        ));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        $categories = Category::all();

        return view('merchant.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'normal_price' => 'required|numeric|min:1',
            'surplus_price' => 'required|numeric|min:1|lt:normal_price',
            'stock' => 'required|integer|min:0',
            'pickup_start' => 'required|date_format:H:i',
            'pickup_end' => 'required|date_format:H:i|after:pickup_start',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('products', 'public');
        }

        $merchant->products()->create($validated);

        return redirect()
            ->route('merchant.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $merchant = auth()->user()->merchant;

        // Memastikan produk merupakan milik merchant yang login.
        $product = $merchant->products()->findOrFail($product->id);

        $categories = Category::all();

        return view('merchant.products.edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Memperbarui produk.
     */
    public function update(Request $request, Product $product)
    {
        $merchant = auth()->user()->merchant;

        // Memastikan merchant hanya bisa mengubah produknya sendiri.
        $product = $merchant->products()->findOrFail($product->id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'normal_price' => 'required|numeric|min:1',
            'surplus_price' => 'required|numeric|min:1|lt:normal_price',
            'stock' => 'required|integer|min:0',
            'pickup_start' => 'required|date_format:H:i',
            'pickup_end' => 'required|date_format:H:i|after:pickup_start',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }

            $validated['photo'] = $request->file('photo')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('merchant.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy($id)
    {
        $merchant = auth()->user()->merchant;

        // Cari produk berdasarkan ID dan pastikan milik merchant
        $product = $merchant->products()->findOrFail($id);

        // Hapus foto produk jika tersedia
        if ($product->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')
                ->delete($product->photo);
        }

        // Hapus produk
        $product->delete();

        return redirect()
            ->route('merchant.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
