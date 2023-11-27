<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $productCount = \DB::table('products')
            ->selectRaw('SUM(CASE WHEN available_quantity > 0 THEN 1 ELSE 0 END) as inStockCount, SUM(CASE WHEN available_quantity = 0 THEN 1 ELSE 0 END) as outStockCount')
            ->first();
        $userCount = Client::get()->count();
                        
        return Inertia::render(
            'Dashboard',
            [
                'breadcrumb' => readable('dashboard'),
                'productCount' => $productCount,
                'userCount' => $userCount,
            ]
        );
    }
}
