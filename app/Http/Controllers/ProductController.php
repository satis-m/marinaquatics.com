<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function list($subCategory)
    {
        $products = Product::query()
            ->where('sub_category', $subCategory)
            ->orderBy('slug')
            ->with('media', 'currentDiscount')
            ->get();

        return Inertia::render(
            'Product/List',
            [
                'products' => $products,
                'isLoggedIn' => auth()->user(),
            ]);
        dd($products);
    }
}
