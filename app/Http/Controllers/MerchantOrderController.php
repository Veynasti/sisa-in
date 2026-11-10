<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PlatformCommission;
use Illuminate\Support\Facades\DB;

class MerchantOrderController extends Controller
{
    /**
     * Memastikan pesanan memang milik merchant yang sedang login.
     */
    private function findMerchantOrder($orderId, $merchant)
    {
        return Order::whereHas('items.product', function ($query) use ($merchant) {
            $query->where('merchant_id', $merchant->id);
        })->findOrFail($orderId);
    }

    /**
     * Menampilkan daftar pesanan masuk merchant.
     */
    public function index()
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $orders = Order::with([
                'user',
                'items.product',
                'payment',
            ])
            ->whereHas('items.product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->latest()
            ->get();

        return view('merchant.orders.index', compact('orders'));
    }

    /**
     * Menampilkan riwayat penjualan merchant.
     */
    public function salesHistory()
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $filters = request()->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $search = $filters['search'] ?? null;

        $ordersQuery = Order::with([
                'user',
                'items.product',
                'payment',
            ])
            ->whereHas('items.product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->whereIn('status', [
                'paid',
                'ready_for_pickup',
                'completed',
            ])
            ->where('payment_status', 'paid');

        if ($search) {
            $ordersQuery->where(function ($query) use ($search) {
                $query->where('order_code', 'ILIKE', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ILIKE', "%{$search}%");
                    })
                    ->orWhereHas('items.product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'ILIKE', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['start_date'])) {
            $ordersQuery->whereDate(
                'created_at',
                '>=',
                $filters['start_date']
            );
        }

        if (!empty($filters['end_date'])) {
            $ordersQuery->whereDate(
                'created_at',
                '<=',
                $filters['end_date']
            );
        }

        $totalTransactions = (clone $ordersQuery)->count();

        $filteredOrderIds = (clone $ordersQuery)->select('orders.id');

        $totalSales = OrderItem::whereHas('product', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->whereIn('order_id', $filteredOrderIds)
            ->sum('subtotal');

        $orders = $ordersQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('merchant.sales.index', compact(
            'orders',
            'totalTransactions',
            'totalSales',
            'filters'
        ));
    }

    /**
     * Merchant mengonfirmasi pembayaran pelanggan
     * sekaligus mencatat komisi 5% untuk Sisa.in.
     */
    public function confirmPayment($orderId)
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $this->findMerchantOrder($orderId, $merchant);

        DB::transaction(function () use ($orderId, $merchant) {

            $order = Order::whereHas('items.product', function ($query) use ($merchant) {
                    $query->where('merchant_id', $merchant->id);
                })
                ->lockForUpdate()
                ->findOrFail($orderId);

            $payment = Payment::where('order_id', $order->id)
                ->lockForUpdate()
                ->first();

            if ($order->status === 'cancelled') {
                throw new \Exception('Pesanan sudah dibatalkan.');
            }

            if ($order->payment_status === 'paid') {
                throw new \Exception('Pembayaran sudah dikonfirmasi.');
            }

            if (!$payment) {
                throw new \Exception('Data pembayaran tidak ditemukan.');
            }

            if ($payment->status !== 'pending') {
                throw new \Exception('Pembayaran tidak dapat dikonfirmasi.');
            }

            if (
                $payment->payment_method === 'qris'
                && !$payment->payment_proof
            ) {
                throw new \Exception('Bukti pembayaran QRIS belum diunggah.');
            }

            // ==========================================
            // 1. Hitung total penjualan milik merchant
            // ==========================================

            $grossAmount = OrderItem::where('order_id', $order->id)
                ->whereHas('product', function ($query) use ($merchant) {
                    $query->where('merchant_id', $merchant->id);
                })
                ->sum('subtotal');

            if ($grossAmount <= 0) {
                throw new \Exception('Total penjualan merchant tidak valid.');
            }

            // ==========================================
            // 2. Hitung komisi Sisa.in sebesar 5%
            // ==========================================

            $commissionRate = 5.00;

            $commissionAmount = round(
                (float) $grossAmount * ($commissionRate / 100),
                2
            );

            $merchantAmount = round(
                (float) $grossAmount - $commissionAmount,
                2
            );

            // ==========================================
            // 3. Konfirmasi pembayaran
            // ==========================================

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $order->update([
                'payment_status' => 'paid',
                'status' => 'paid',
            ]);

            // ==========================================
            // 4. Catat komisi ke platform_commissions
            // ==========================================

            PlatformCommission::firstOrCreate(
                [
                    'order_id' => $order->id,
                    'merchant_id' => $merchant->id,
                ],
                [
                    'gross_amount' => $grossAmount,
                    'commission_rate' => $commissionRate,
                    'commission_amount' => $commissionAmount,
                    'merchant_amount' => $merchantAmount,
                    'payment_method' => $payment->payment_method,
                    'collection_status' => 'pending',
                ]
            );
        });

        return redirect()
            ->route('merchant.orders.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi dan komisi 5% berhasil dicatat.');
    }

    /**
     * Merchant mengubah status pesanan menjadi siap diambil.
     */
    public function markReady($orderId)
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $order = $this->findMerchantOrder($orderId, $merchant);

        if ($order->status !== 'paid' || $order->payment_status !== 'paid') {
            return back()->with('error', 'Pesanan belum dibayar atau belum dikonfirmasi.');
        }

        $order->update([
            'status' => 'ready_for_pickup',
        ]);

        return back()->with('success', 'Pesanan berhasil ditandai siap diambil.');
    }

    /**
     * Merchant menyelesaikan pesanan.
     */
    public function completeOrder($orderId)
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $order = $this->findMerchantOrder($orderId, $merchant);

        if ($order->status !== 'ready_for_pickup') {
            return back()->with('error', 'Pesanan belum siap diambil.');
        }

        if ($order->payment_status !== 'paid') {
            return back()->with('error', 'Pembayaran pesanan belum lunas.');
        }

        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Pesanan berhasil diselesaikan.');
    }
}
