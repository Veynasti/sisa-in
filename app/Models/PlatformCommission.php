<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlatformCommission extends Model
{
    protected $fillable = [
        'order_id',
        'merchant_id',
        'gross_amount',
        'commission_rate',
        'commission_amount',
        'merchant_amount',
        'payment_method',
        'collection_status',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'merchant_amount' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function invoiceItem(): HasOne
    {
        return $this->hasOne(CommissionInvoiceItem::class, 'commission_id');
    }
}
