<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class StoreSellController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'comboOffer'])->orderBy('slug')->get();

        return Inertia::render(
            'StoreSell/Index',
            [
                'breadcrumb' => readable('store-sell'),
                'products' => $products,
            ]
        );
    }
}
