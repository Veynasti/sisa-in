<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MerchantCommissionInvoice extends Model
{
    protected $fillable = [
        'merchant_id',
        'invoice_number',
        'period_start',
        'period_end',
        'total_commission',
        'status',
        'due_date',
        'paid_at',
        'payment_method',
        'payment_reference',
        'payment_proof',
        'verified_by',
        'rejection_reason',
        'submitted_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'total_commission' => 'decimal:2',
        ];
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(CommissionInvoiceItem::class, 'invoice_id');
    }

    public function commissions(): BelongsToMany
    {
        return $this->belongsToMany(
            PlatformCommission::class,
            'commission_invoice_items',
            'invoice_id',
            'commission_id'
        )->withTimestamps();
    }
}
