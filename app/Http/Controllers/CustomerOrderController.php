<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerOrderController extends Controller
{
    // Halaman konfirmasi pemesanan produk
    public function create($productId)
    {
        $product = Product::with(['merchant', 'category'])
            ->where('status', 'available')
            ->whereHas('merchant', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->findOrFail($productId);

        if ($product->stock < 1) {
            return redirect()->route('dashboard')
                ->with('error', 'Maaf, stok produk sudah habis.');
        }

        return view('orders.create', compact('product'));
    }

    // Menyimpan pesanan
    public function store(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $order = DB::transaction(function () use ($request, $productId) {

                $product = Product::with('merchant')
                    ->where('status', 'available')
                    ->whereHas('merchant', function ($query) {
                        $query->where('verification_status', 'approved');
                    })
                    ->lockForUpdate()
                    ->findOrFail($productId);

                if ($request->quantity > $product->stock) {
                    throw new \RuntimeException(
                        'Stok tidak mencukupi. Silakan periksa kembali jumlah pesanan.'
                    );
                }

                $price = $product->surplus_price;
                $quantity = (int) $request->quantity;
                $subtotal = $price * $quantity;

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_code' => 'SIS-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                    'total_amount' => $subtotal,
                    'status' => 'pending',
                    'pickup_code' => strtoupper(Str::random(6)),
                    'payment_status' => 'pending',
                ]);

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // Stok dikurangi ketika pesanan dibuat.
                $product->decrement('stock', $quantity);

                return $order;
            });

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan proses pembayaran.');

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Halaman daftar pesanan pelanggan
    public function index()
    {
        $orders = Order::with(['items.product.merchant', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Membatalkan pesanan oleh pelanggan
    public function cancel($orderId)
    {
        try {
            DB::transaction(function () use ($orderId) {

                // Pastikan pesanan milik pelanggan yang sedang login.
                $order = Order::where('user_id', auth()->id())
                    ->lockForUpdate()
                    ->findOrFail($orderId);

                // Pembatalan hanya diperbolehkan saat status masih pending.
                if ($order->status !== 'pending') {
                    throw new \RuntimeException(
                        'Pesanan tidak dapat dibatalkan karena sudah diproses.'
                    );
                }

                $payment = $order->payment;

                // Pesanan yang sudah dibayar tidak dapat dibatalkan.
                if (
                    $order->payment_status === 'paid' ||
                    ($payment && $payment->status === 'paid')
                ) {
                    throw new \RuntimeException(
                        'Pesanan yang sudah dibayar tidak dapat dibatalkan.'
                    );
                }

                // Bukti QRIS yang sudah diunggah harus diperiksa merchant.
                if ($payment && !empty($payment->payment_proof)) {
                    throw new \RuntimeException(
                        'Pesanan tidak dapat dibatalkan karena bukti pembayaran QRIS sudah diunggah.'
                    );
                }

                // Kembalikan stok setiap produk dalam pesanan.
                $order->load('items');

                foreach ($order->items as $item) {
                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }

                // Tandai pembayaran sebagai gagal jika sudah ada data pembayaran.
                if ($payment) {
                    $payment->status = 'failed';
                    $payment->save();
                }

                // Ubah status pesanan menjadi dibatalkan.
                $order->status = 'cancelled';
                $order->payment_status = 'failed';
                $order->save();
            });

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan. Stok produk telah dikembalikan.');

        } catch (\RuntimeException $e) {
            return redirect()->route('orders.index')
                ->with('error', $e->getMessage());
        }
    }
}
