<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id', 'id');
    }
}
