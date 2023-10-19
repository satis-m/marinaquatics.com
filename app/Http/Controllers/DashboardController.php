<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Order;
use Exception;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller {

    public function index() {

        return Inertia::render('Dashboard/Index');
    }

    public function orderList() {
        $data['orders'] = $orders = Order::where('customer_id', auth('client')->user()->id)
                       ->with(['orderItems', 'orderItems.product'])
                       ->latest()
                       ->get()
                       ->map(function ($order) {
                            return [
                                'id' => $order->id,
                                'order_no' => $order->order_no,
                                'total_amount' => $order->total_amount,
                                'order_status' => $order->order_status,
                                'order_date' => Carbon::parse($order->created_at)->format('d M Y h:i a'),
                                'delivery_type' => $order->delivery_type,
                                'delivered_date' => $order->delivered_on ? Carbon::parse($order->delivered_on)->format('d M Y h:i a') : null,
                                'order_items' => $order->orderItems->map(function ($orderItem) {
                                    return [
                                        'item_total' => $orderItem->item_total_price,
                                        'quantity' => $orderItem->quantity,
                                        'offer_name' => $orderItem->offer_name,
                                        'offer_price' => $orderItem->offer_price,
                                        'item_total_price' => $orderItem->item_total_price,
                                        'product_name' => $orderItem->product->name,
                                        'product_slug' => $orderItem->product->slug,
                                        'product_main_picture' => $orderItem->product->main_picture,
                                    ];
                                }),
                            ];
                        });

        return Inertia::render('Dashboard/Index', $data);
    }

    public function shippingAddress() {
        return Inertia::render('Dashboard/Index');
    }

    public function changePassword() {
        return Inertia::render('Dashboard/Index');
    }

    public function updatePersonalInfo() {
        try
        {
            Client::where('id',auth('client')->user()->id)->update([
                'name'=>request('name'),
                'dob'=>request('dob'),
                'gender'=>request('gender')
            ]);
            ClientAddress::where('customer_id',auth('client')->user()->id)->update([
                'billing_contact' => request('contact'),
                'billing_city' => request('city'),
                'billing_address' => request('address'),
                'billing_state' => request('state')
            ]);
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Personal Information updated Successfully');

    }

    public function updateShippingInfo() {
        try
        {
            ClientAddress::where('customer_id',auth('client')->user()->id)->update([
                'shipping_contact' => request('contact'),
                'shipping_city' => request('city'),
                'shipping_address' => request('address'),
                'shipping_state' => request('state'),
                'shipping_landmark' => request('landmark')
            ]);
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Shipping Information updated Successfully');

    }
}
