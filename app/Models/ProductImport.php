<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImport extends Model
{
    protected $hidden = [
        'cost_price',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }
}
