<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public $timestamps = false;

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }

    public function lastDiscount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function scopeWithLastDiscount($query)
    {
        $query->addSelect(['last_discount_id' => Discount::select('id')
            ->whereColumn('product_slug', 'cart_items.product_slug')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('id', 'desc')
            ->take(1),
        ])->with('lastDiscount');
    }
}
