<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CartController extends Controller {

    public function store() {
        try {
            $cartId = Cart::firstOrCreate(['customer_id' => auth('client')->user()->id])->first()->id;
            $itemExist = self::productExist($cartId, request('product_slug'));
            if ($itemExist == null) {
                CartItem::create([
                    'cart_id' => $cartId,
                    'product_slug' => request('product_slug'),
                    'quantity' => request('quantity'),
                    'offer_name' => request('offer')['name'],
                    'offer_quantity' => request('offer')['quantity'],
                    'offer_price' => request('offer')['price'],
                ]);
            } else {
                if (strtolower($itemExist->offer_name) == strtolower(request('offer')['name'])) {
                    $newQuantity = (int) $itemExist->quantity + (int) request('quantity');
                    $offerQuantity = $itemExist->offer_quantity;
                    $availableQuantity = $itemExist->product->available_quantity;

                    if (($newQuantity * $offerQuantity) <= $availableQuantity) {
                        CartItem::query()
                                ->where('id', $itemExist->id)
                                ->where('cart_id', $itemExist->cart_id)
                                ->update(['quantity' => $newQuantity]);
                    } else {
                        $maxQuantity = floor($availableQuantity / $offerQuantity);
                        CartItem::query()
                                ->where('id', $itemExist->id)
                                ->where('cart_id', $itemExist->cart_id)
                                ->update(['quantity' => $maxQuantity]);
                        return redirect()->back()->with('error', 'Cart item has reached stock limit');
                    }
                } else {
                    return redirect()->back()->with('error', 'Item already exist in cart with different offer');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product added to Cart Successfully');
    }

    public function update() {
        $cartId = Cart::where(['customer_id' => auth('client')->user()->id])->first()->id;
        if (request('quantity') > 0) {
            CartItem::query()
                    ->where('id', request('itemId'))
                    ->where('cart_id', $cartId)
                    ->update(['quantity' => request('quantity')]);
        } else {
            return self::destroy();
        }
        return redirect()->back()->with('success', 'Cart updated Successfully');
    }

    public function destroy() {
        $cartId = Cart::where(['customer_id' => auth('client')->user()->id])->first()->id;
        try {
            CartItem::query()
                    ->where('id', request('itemId'))
                    ->where('cart_id', $cartId)
                    ->delete();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product removed From Cart Successfully');
    }

    public function productExist($cartId, $productSlug) {
        return CartItem::query()
                       ->with('product:slug,available_quantity')
                       ->where('product_slug', $productSlug)
                       ->where('cart_id', $cartId)
                       ->first();
    }

    public function checkout() {
        return Inertia::render('Cart/Checkout/Index', [
            //            'canLogin' => Route::has('login'),
            //            'canRegister' => Route::has('register'),
            //            'laravelVersion' => Application::VERSION,
            //            'phpVersion' => PHP_VERSION,
            //            'products' => $products,
            //            'sliders' => $sliders,
            //            'banners' => $banners,
        ]);
    }

    public function placeOrder() {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => auth('client')->user()->id,
                'discount' => 0,
                'subtotal_amount' => 0,
                'total_amount' => 0,
                'payment_method' => request('payment_method'),
                'payment_status' => 'queue',
                'payment_info' => '',
                'order_status' => 'queue',
                'order_type' => 'website',
                'delivery_type' => request('delivery_type'),
                'note' => request('order_note')??''
            ]);

            Billing::create([
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
                    'item_total_price' => $itemTotalPrice
                ]);
                $cartId = $item->cart_id;
            }
            $order->subtotal_amount = $totalPrice;
            $order->total_amount = $totalPrice;
            $order->save();

            Cart::find($cartId)->delete();
            CartItem::where('cart_id', $cartId)->delete();

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

    public function proceedPayment() {
        if (self::placeOrder()) {
            return to_route('client.dashboard.order-history')->with('success', 'Your order has be placed Succesfully');
        }
        return to_route('client.dashboard.order-history')->with('error', 'Error while creating order.');
    }

    public function succeedPayment() {
        // Retrieve the Base64 encoded parameters from the query string
        $base64EncodedParams = request()->query('data');

        // Decode the Base64 encoded parameters
        $decodedParams = base64_decode($base64EncodedParams);

        // Convert the decoded JSON data to an array
        $decodedData = json_decode($decodedParams, true);
        dd($decodedData);
    }

    public function esewaPayment() {
        $s = hash_hmac('sha256', 'total_amount=6,transaction_uuid=qsq3sdfaap1s,product_code=EPAYTEST', '8gBm/:&EnhH.1/q', true);
        $signature = base64_encode($s);
        $data = [
            "amount" => "6",
            "failure_url" => "https://marineaquatics.test/cart/checkout",
            "product_delivery_charge" => "0",
            "product_service_charge" => "0",
            "product_code" => "EPAYTEST",
            "signature" => $signature,
            "signed_field_names" => "total_amount,transaction_uuid,product_code",
            "success_url" => "https://marineaquatics.test/cart/success-order",
            "tax_amount" => "0",
            "total_amount" => "6",
            "transaction_uuid" => "qsq3sdfaap1s"
        ];

        $url = 'https://rc-epay.esewa.com.np/api/epay/main/v2/form';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
        } else {
            // If you want to capture the final URL after redirects, you can use the 'curl_getinfo' function
            $resposneData = json_decode($response);
            $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        }
        curl_close($ch);
        if ($finalUrl != $url) {
            return Inertia::location($finalUrl);
        } else {
            return to_route('client.dashboard.order-history')->with('error', $resposneData->error_message);
        }
    }
}
