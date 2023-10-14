<?php

namespace App\Services;

use App\Models\Billing;
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
                ]);
                $quantityToDecrement = $product['comboQuantity'] * $product['quantity'];
                $product = Product::where('slug', $product['product'])->first();
                $newQuantity = $product->available_quantity - $quantityToDecrement;
                $product->update([
                    'available_quantity' => $newQuantity,
                ]);
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
}
