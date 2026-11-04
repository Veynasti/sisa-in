<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\OrderItem;

class Product extends Model
{
    protected $fillable = [
        'merchant_id',
        'category_id',
        'name',
        'description',
        'normal_price',
        'surplus_price',
        'stock',
        'pickup_start',
        'pickup_end',
        'photo',
        'status',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
