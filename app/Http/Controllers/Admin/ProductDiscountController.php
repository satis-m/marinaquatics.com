<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;

class ProductDiscountController extends Controller
{
    public function store($productId)
    {
        try {
            (new ProductService())->addDiscount($productId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Updated Successfully');
    }

    public function update($productId, $discountId)
    {
        try {
            (new ProductService())->updateDiscount($productId, $discountId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Updated Successfully');
    }
}
