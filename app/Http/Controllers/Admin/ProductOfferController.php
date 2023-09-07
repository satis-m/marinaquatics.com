<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;

class ProductOfferController extends Controller
{
    public function update($productId)
    {
        try {
            (new ProductService())->updateOffer($productId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Updated Successfully');
    }
}
