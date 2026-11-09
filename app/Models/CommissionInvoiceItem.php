<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissionInvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'commission_id',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            MerchantCommissionInvoice::class,
            'invoice_id'
        );
    }

    public function commission(): BelongsTo
    {
        return $this->belongsTo(
            PlatformCommission::class,
            'commission_id'
        );
    }
}
