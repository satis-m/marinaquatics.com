<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->order_no = generateUniqueOrderNumber();
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function billing()
    {
        return $this->hasOne(Billing::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id', 'id');
    }
}
