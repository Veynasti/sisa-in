<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);

        $products = Product::with('merchant')
            ->whereIn('id', array_keys($cart))
            ->get();

        $cartItems = $products->map(function ($product) use ($cart) {
            $quantity = $cart[$product->id];

            return [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->surplus_price * $quantity,
            ];
        });

        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Menambahkan produk ke keranjang
    public function add($productId)
    {
        $product = Product::with('merchant')
            ->where('id', $productId)
            ->where('status', 'available')
            ->whereHas('merchant', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->firstOrFail();

        $cart = session()->get('cart', []);

        $currentQuantity = $cart[$productId] ?? 0;

        if ($currentQuantity + 1 > $product->stock) {
            return back()->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        }

        $cart[$productId] = $currentQuantity + 1;

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Mengubah jumlah produk
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return redirect()->route('cart.index');
        }

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $cart[$productId] = $request->quantity;

        session()->put('cart', $cart);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    // Menghapus produk dari keranjang
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        unset($cart[$productId]);

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
