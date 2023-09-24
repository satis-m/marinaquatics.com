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
}
