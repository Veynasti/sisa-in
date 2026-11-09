<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class MerchantOrderController extends Controller
{
    /**
     * Menampilkan pesanan yang berisi produk milik merchant.
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
     * Mengonfirmasi pembayaran QRIS maupun COD.
     */
    public function confirmPayment($orderId)
    {
        $merchant = auth()->user()->merchant;

        if (!$merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

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
                abort(403, 'Pesanan yang dibatalkan tidak dapat dikonfirmasi.');
            }

            if ($order->payment_status === 'paid') {
                abort(403, 'Pembayaran pesanan ini sudah dikonfirmasi.');
            }

            if (!$payment) {
                abort(404, 'Data pembayaran tidak ditemukan.');
            }

            if ($payment->status === 'paid') {
                abort(403, 'Pembayaran sudah dikonfirmasi.');
            }

            // Validasi khusus pembayaran QRIS.
            if ($payment->payment_method === 'qris') {
                if (!$payment->payment_proof) {
                    abort(403, 'Pelanggan belum mengunggah bukti pembayaran QRIS.');
                }
            }

            // Pastikan metode pembayaran valid.
            if (!in_array($payment->payment_method, ['qris', 'cod'])) {
                abort(403, 'Metode pembayaran tidak valid.');
            }

            // Konfirmasi pembayaran.
            $payment->status = 'paid';
            $payment->paid_at = now();
            $payment->save();

            // Perbarui status pesanan.
            $order->payment_status = 'paid';
            $order->status = 'paid';
            $order->save();
        });

        return redirect()
            ->route('merchant.orders.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}
