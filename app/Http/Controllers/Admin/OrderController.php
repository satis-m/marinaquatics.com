<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected $permissionName = 'store-sell';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function store()
    {
        try {
            (new OrderService())->add();
        } catch (\Exception $e) {
            return Redirect::route('storeSell.list')->with('error', $e->getMessage());
        }

        return Redirect::route('storeSell.list')->with('success', 'Order Entered Successfully');
    }

    public function listAll()
    {
        $orderList = Order::query()
            ->where('order_type', 'website')
            ->with(['orderItems', 'orderItems.product', 'billing'])
            ->get();

        return Inertia::render(
            'ProductOrder/Index',
            [
                'breadcrumb' => readable('website-sell'),
                'orderList' => $orderList,
            ]
        );
    }

    public function cancelOrder()
    {
        $orderNo = request('orderNo');
        if ((new OrderService())->cancelOrder($orderNo)) {
            return redirect()->back()->with('success', 'Order No '.$orderNo.' order has been Cancelled');
        }

        return redirect()->back()->with('error', 'Error while cancelling order.');
    }

    public function updateOrderStatus($orderNo)
    {
        try {
            $order = Order::where('order_no', $orderNo)->first();
            $order->delivered_on = request('delivery_date');
            $order->payment_status = request('payment_status');
            $order->order_status = request('order_status');
            $order->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Order Updated Successfully');
    }
}
