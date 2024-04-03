<?php

namespace App\Services;

use App\Events\CancelOrder;
use App\Events\NewOrder;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function add()
    {
        DB::beginTransaction();
        try {
            $cusotmerId = Client::where('contact', request('billingInfo')['contact'])->first('id')?->id;

            $order = Order::create([
                'order_type' => 'in-store',
                'customer_id' => $cusotmerId,
                'discount' => request('discount') > 0 ? request('discount') : '0',
                'subtotal_amount' => request('subtotalAmount'),
                'total_amount' => request('totalAmount'),
                'payment_method' => request('billingInfo')['payment_method'],
                'payment_status' => 'verified',
                'payment_info' => request('billingInfo')['payment_info'],
            ]);
            $products = request('products');
            foreach ($products as $product) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_slug' => $product['product'],
                    'quantity' => $product['quantity'],
                    'offer_name' => $product['combo'],
                    'offer_price' => $product['rate'],
                    'offer_quantity' => $product['comboQuantity'],
                    'item_total_price' => (float) $product['rate'] * ((int) $product['comboQuantity'] * (int) $product['quantity']),
                ]);
                $quantityToDecrement = $product['comboQuantity'] * $product['quantity'];
                Product::where('slug', $product['product'])->decrement('available_quantity', $quantityToDecrement);
            }
            Billing::create([
                'order_id' => $order->id,
                'billing_name' => request('billingInfo')['name'],
                'billing_address' => request('billingInfo')['address'],
                'billing_contact' => request('billingInfo')['contact'],
                'vat_pan' => request('billingInfo')['vatpan'],
            ]);

            DB::commit();

            return true;
        } catch (QueryException $e) {
            //database related exception
            DB::rollBack();

            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            //general exception
            DB::rollBack();

            return throw new \Exception($e->getMessage());
        }

    }

    public function placeOrder()
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => auth('client')->user()->id,
                'discount' => 0,
                'subtotal_amount' => 0,
                'total_amount' => 0,
                'payment_method' => request('payment_method'),
                'payment_status' => 'pending',
                'payment_info' => '',
                'order_status' => 'queue',
                'order_no' => request('order_number'),
                'order_type' => 'website',
                'delivery_type' => request('delivery_type'),
                'note' => request('order_note') ?? '',
            ]);

            $billingInfo = Billing::create([
                'order_id' => $order->id,
                'billing_state' => request('billing_info')['state'],
                'billing_city' => request('billing_info')['city'],
                'billing_name' => request('billing_info')['full_name'],
                'billing_contact' => request('billing_info')['phone'],
                'billing_address' => request('billing_info')['address'],
                'billing_landmark' => request('billing_info')['landmark'],
                'shipping_state' => (request('delivery_type') == 'pick' ? null : (request('ship_different') == true ? request('shipping_info')['full_name'] : request('billing_info')['state'])),
                'shipping_city' => (request('delivery_type') == 'pick' ? null : (request('ship_different') == true ? request('shipping_info')['full_name'] : request('billing_info')['city'])),
                'shipping_name' => (request('delivery_type') == 'pick' ? null : (request('ship_different') == true ? request('shipping_info')['full_name'] : request('billing_info')['full_name'])),
                'shipping_contact' => (request('delivery_type') == 'pick' ? null : (request('ship_different') == true ? request('shipping_info')['full_name'] : request('billing_info')['phone'])),
                'shipping_address' => (request('delivery_type') == 'pick' ? null : (request('ship_different') == true ? request('shipping_info')['full_name'] : request('billing_info')['address'])),
                'shipping_landmark' => (request('delivery_type') == 'pick' ? null : (request('ship_different') == true ? request('shipping_info')['full_name'] : request('billing_info')['landmark'])),
            ]);

            $cartItems = CartItem::query()
                ->join('carts', 'carts.id', '=', 'cart_items.cart_id')
                ->withLastDiscount()
                ->where('carts.customer_id', auth('client')->user()->id)
                ->get();
            $cartItems->load('product');
            $cartItems->transform(function ($item) {
                $item->available_quantity = $item->product->available_quantity;
                unset($item->product);

                return $item;
            });

            $totalPrice = 0;
            $cartId = 0;

            $deliveryType = $order->payment_method == 'bank' ? 'Bank Transfer' : 'Cash On Delivery';
            $paymentMethod = $order->delivery_type == 'ship' ? 'Shipping' : 'Store Pickup';

            $orderedInfoTable = '<ul>';
            $orderedInfoTable .= '<li><b>Customer Name</b>: '.$billingInfo->billing_name.'</li>';
            $orderedInfoTable .= '<li><b>Order No:</b>'.$order->order_no.'</li>';
            $orderedInfoTable .= '<li><b>Payment Method:</b>'.$paymentMethod.'</li>';
            $orderedInfoTable .= '<li><b>Delivery Type:</b>'.$deliveryType.'</li>';
            $orderedInfoTable .= '<li><b>Billing Contact:</b> '.$billingInfo->billing_contact.'</li>';
            $orderedInfoTable .= '<li><b>Billing Adress:</b> '.$billingInfo->billing_address.'</li>';
            if ($billingInfo->billing_landmark != '') {
                $orderedInfoTable .= '<li><b>Billing Landmark:</b> '.$billingInfo->billing_landmark.'</li>';
            }
            $orderedInfoTable .= '<li><b>Product List:</b></li>';
            $orderedInfoTable .= '<ol>';
            foreach ($cartItems as $item) {
                $offer_price = (float) $item->offer_price;
                if ($item->lastDiscount != null && strtolower($item->offer_name) == 'standard') {
                    $offer_price = (float) $item->offer_price - (((int) $item->lastDiscount->discount / 100) * (float) $item->offer_price);
                }
                $itemTotalPrice = $offer_price * ((int) $item->quantity * (int) $item->offer_quantity);
                $totalPrice += $itemTotalPrice;
                OrderItem::create([
                    'product_slug' => $item->product_slug,
                    'offer_quantity' => $item->offer_quantity,
                    'offer_price' => $offer_price,
                    'offer_name' => $item->offer_name,
                    'order_id' => $order->id,
                    'quantity' => $item->quantity,
                    'item_total_price' => $itemTotalPrice,
                ]);
                $orderedInfoTable .= '<li><b>'.readable($item->product_slug).'</b> - <b>('.$item->quantity.')</b></li>';
                $cartId = $item->cart_id;
            }
            $order->subtotal_amount = $totalPrice;
            $order->total_amount = $totalPrice;
            $order->save();

            Cart::find($cartId)->delete();
            CartItem::where('cart_id', $cartId)->delete();
            DB::commit();

            $orderedInfoTable .= '</ol>';
            $orderedInfoTable .= '<li><b>Total Amount:</b> Rs. '.number_format($totalPrice, 2).'</li>';
            $orderedInfoTable .= '</ul>';

            event(new NewOrder($orderedInfoTable));

            return true;
        } catch (QueryException $e) {
            //database related exception
            DB::rollBack();

            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            //general exception
            DB::rollBack();

            return throw new \Exception($e->getMessage());
        }
    }

    public function cancelOrder($orderNumber)
    {

        if (request()->is('admin/*')) {
            $order = Order::where('order_no', $orderNumber)->first();
        } else {
            $order = Order::where('order_no', $orderNumber)->where('customer_id', auth('client')->user()->id)->first();
        }
        if ($order) {
            $cancelProducts = OrderItem::where('order_id', $order->id)->get();
            DB::beginTransaction();
            try {
                foreach ($cancelProducts as $cancelProduct) {
                    $quantityToIncrement = $cancelProduct->offer_quantity * $cancelProduct->quantity;
                    Product::where('slug', $cancelProduct->product_slug)->increment('available_quantity', $quantityToIncrement);
                }
                $order->order_status = 'cancelled';
                $order->save();
                DB::commit();
                $orderInfo = (object) [
                    'orderNo' => $orderNumber,
                ];
                if (request()->is('admin/*')) {
                } else {
                    event(new CancelOrder($orderInfo));
                }

                return true;
            } catch (QueryException $e) {
                //database related exception
                DB::rollBack();

                return throw new \Exception($e->errorInfo[2]);
            } catch (\Exception $e) {
                //general exception
                DB::rollBack();

                return throw new \Exception($e->getMessage());
            }
        }
    }
}
