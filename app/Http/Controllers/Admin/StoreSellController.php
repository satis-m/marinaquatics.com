<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class StoreSellController extends Controller
{
    public function index()
    {
        $productCount = \DB::table('products')
            ->selectRaw('SUM(CASE WHEN available_quantity > 0 THEN 1 ELSE 0 END) as inStockCount, SUM(CASE WHEN available_quantity = 0 THEN 1 ELSE 0 END) as outStockCount')
            ->first();

        return Inertia::render(
            'StoreSell/Index',
            [
                'breadcrumb' => readable('store-sell'),
                'productCount' => $productCount,
            ]
        );
    }
}
