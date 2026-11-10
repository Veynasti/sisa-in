<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PlatformWithdrawal extends Model
{
    protected $fillable = [
        'withdrawal_number',
        'amount',
        'withdrawal_date',
        'destination_account',
        'account_holder',
        'description',
        'proof',
        'admin_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'withdrawal_date' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
