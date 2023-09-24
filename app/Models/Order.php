<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->order_no = static::generateUniqueOrderNumber();
        });

    }

    public static function generateUniqueOrderNumber($length = 6)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        do {
            $orderNumber = '';

            for ($i = 0; $i < $length; $i++) {
                $orderNumber .= $characters[rand(0, $charactersLength - 1)];
            }
            $orderNumber = date('ym').'-'.$orderNumber;
            // Check if the order number is already used
            $isUnique = ! \DB::table('orders')->where('order_no', $orderNumber)->exists();

        } while (! $isUnique);

        return $orderNumber;
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
