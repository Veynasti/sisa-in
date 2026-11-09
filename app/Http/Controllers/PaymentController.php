<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran.
     */
    public function method($orderId)
    {
        $order = Order::with([
            'items.product.merchant',
            'payment',
        ])
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);

        return view('payments.method', compact('order'));
    }

    /**
     * Menyimpan metode pembayaran satu kali saja.
     */
    public function storeMethod(Request $request, $orderId)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,cod',
        ]);

        $order = Order::with('items.product.merchant')
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);

        if ($order->status === 'cancelled') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan yang dibatalkan tidak dapat dibayar.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        // Cegah pelanggan mengganti metode pembayaran.
        $existingPayment = Payment::where('order_id', $order->id)->first();

        if ($existingPayment) {
            return redirect()->route('payments.method', $order->id)
                ->with('error', 'Metode pembayaran sudah dipilih dan tidak dapat diubah.');
        }

        // Pastikan merchant memiliki QRIS jika pelanggan memilih QRIS.
        if ($request->payment_method === 'qris') {
            $merchant = $order->items->first()?->product?->merchant;

            if (!$merchant || !$merchant->qris_image) {
                return back()
                    ->withErrors([
                        'payment_method' => 'Merchant belum mengunggah gambar QRIS. Silakan pilih Bayar di Tempat atau hubungi merchant.',
                    ])
                    ->withInput();
            }
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount' => $order->total_amount,
            'status' => 'pending',
        ]);

        return redirect()->route('payments.method', $order->id)
            ->with('success', 'Metode pembayaran berhasil disimpan dan tidak dapat diubah.');
    }

    /**
     * Mengunggah bukti pembayaran QRIS.
     */
    public function uploadProof(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'payment_proof.required' => 'Silakan pilih bukti pembayaran.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format harus JPG, JPEG, PNG, atau WEBP.',
            'payment_proof.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $order = Order::with('payment')
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);

        if ($order->status === 'cancelled') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan yang dibatalkan tidak dapat menerima bukti pembayaran.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        $payment = $order->payment;

        if (!$payment || $payment->payment_method !== 'qris') {
            return back()->with('error', 'Metode pembayaran QRIS belum dipilih.');
        }

        if ($payment->status === 'paid') {
            return back()->with('error', 'Pembayaran sudah dikonfirmasi merchant.');
        }

        // Cegah penggantian atau pengunggahan ulang bukti pembayaran.
        if ($payment->payment_proof) {
            return back()->with('error', 'Bukti pembayaran sudah dikirim dan sedang menunggu pemeriksaan merchant.');
        }

        $path = $request->file('payment_proof')
            ->store('payment-proofs', 'public');

        $payment->payment_proof = $path;
        $payment->status = 'pending';
        $payment->save();

        return redirect()->route('payments.method', $order->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Silakan tunggu konfirmasi merchant.');
    }
}
