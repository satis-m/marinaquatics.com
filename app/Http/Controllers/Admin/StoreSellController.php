<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Inertia\Inertia;

class StoreSellController extends Controller
{
    protected $permissionName = 'store-sell';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {
        $products = Product::with(['category', 'comboOffer'])->withCurrentDiscount()->orderBy('slug')->get();

        return Inertia::render(
            'StoreSell/Index',
            [
                'breadcrumb' => readable('store-sell'),
                'products' => $products,
            ]
        );
    }

    public function listAll()
    {
        $orderList = Order::query()
            ->where('order_type', 'in-store')
            ->with(['orderItems', 'orderItems.product', 'billing'])
            ->get();

        return Inertia::render(
            'ProductOrder/Index',
            [
                'breadcrumb' => readable('in-store-sell'),
                'orderList' => $orderList,
            ]
        );
    }
}
