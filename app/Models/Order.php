<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'total_amount',
        'status',
        'pickup_code',
        'payment_status',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    // Relasi ke pengguna yang melakukan pemesanan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail produk pesanan
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke pembayaran
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi ke catatan komisi
    public function commissions(): HasMany
    {
        return $this->hasMany(PlatformCommission::class);
    }
}
