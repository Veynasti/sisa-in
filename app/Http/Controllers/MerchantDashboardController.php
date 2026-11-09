<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class MerchantDashboardController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        // 1. Menghitung produk aktif
        $activeProducts = Product::where('merchant_id', $merchant->id)
            ->where('status', 'available')
            ->where('stock', '>', 0)
            ->count();

        // 2. Menghitung pesanan yang masih perlu diproses
        $incomingOrders = Order::whereIn('status', ['pending', 'paid'])
            ->whereHas('items.product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->count();

        // 3. Menghitung pesanan siap diambil
        $readyOrders = Order::where('status', 'ready_for_pickup')
            ->whereHas('items.product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->count();

        // 4. Menghitung total penjualan dari pesanan selesai
        $totalSales = OrderItem::whereHas('product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->sum('subtotal');

        // 5. Mengambil lima pesanan terbaru
        $recentOrders = Order::with([
                'user',
                'items.product',
                'payment',
            ])
            ->whereHas('items.product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('merchant.dashboard', compact(
            'activeProducts',
            'incomingOrders',
            'readyOrders',
            'totalSales',
            'recentOrders'
        ));
    }
}
