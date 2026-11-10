<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'phone',
        'address',
        'photo',
        'verification_status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(PlatformCommission::class);
    }

    public function commissionInvoices(): HasMany
    {
        return $this->hasMany(MerchantCommissionInvoice::class);
    }
}
