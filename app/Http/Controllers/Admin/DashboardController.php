<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $productCount = \DB::table('products')
            ->selectRaw('SUM(CASE WHEN available_quantity > 0 THEN 1 ELSE 0 END) as inStockCount, SUM(CASE WHEN available_quantity = 0 THEN 1 ELSE 0 END) as outStockCount')
            ->first();
        $userCount = Client::groupBy('status')
            ->select('status', DB::raw('count(*) as total'))
            ->pluck('total', 'status');
        $sales = Order::query()
            ->where('payment_status', 'verified')
            ->where('order_status', '!=', 'cancelled')
            ->selectRaw('
                            SUM(CASE WHEN MONTH(created_at) = MONTH(CURRENT_DATE()) THEN total_amount ELSE 0 END) AS monthly_total,
                            SUM(CASE WHEN DATE(created_at) = CURRENT_DATE() THEN total_amount ELSE 0 END) AS today_total,
                            SUM(total_amount) AS till_date_total,
                            MONTHNAME(CURRENT_DATE()) AS current_month
                        ')
            ->first();
        $orders = Order::query()
            ->where('order_status', '!=', 'cancelled')
            ->selectRaw('
                            SUM(CASE WHEN MONTH(created_at) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS monthly_total,
                            SUM(CASE WHEN DATE(created_at) = CURRENT_DATE() THEN 1 ELSE 0 END) AS today_total,
                            count(order_no) AS till_date_total,
                            MONTHNAME(CURRENT_DATE()) AS current_month
                        ')
            ->first();

        return Inertia::render(
            'Dashboard',
            [
                'breadcrumb' => readable('dashboard'),
                'productCount' => $productCount,
                'userCount' => $userCount,
                'sales' => $sales,
                'orders' => $orders,
            ]
        );
    }
}
