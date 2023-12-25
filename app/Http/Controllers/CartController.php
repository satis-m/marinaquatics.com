<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
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


    public function confirmOrder() {

        if ((new OrderService())->placeOrder()) {
            return redirect()->back()->with('success', 'Your order has be placed Succesfully');
        }
        return redirect()->back()->with('error', 'Error while creating order.');
    }

    public function cancelOrder() {
        $orderNo = request('orderNo');
        $isClientOrder = Order::where('order_no',$orderNo)->where('customer_id',auth('client')->user()->id)->count();
        if ($isClientOrder > 0 && (new OrderService())->cancelOrder($orderNo)) {
            return redirect()->back()->with('success', 'Your order has be Cancelled');
        }
        return redirect()->back()->with('error', 'Error while cancelling order.');
    }


//    public function succeedPayment() {
//        // Retrieve the Base64 encoded parameters from the query string
//        $base64EncodedParams = request()->query('data');
//
//        // Decode the Base64 encoded parameters
//        $decodedParams = base64_decode($base64EncodedParams);
//
//        // Convert the decoded JSON data to an array
//        $decodedData = json_decode($decodedParams, true);
//        dd($decodedData);
//    }

//    public function esewaPayment() {
//        $s = hash_hmac('sha256', 'total_amount=6,transaction_uuid=qsq3sdfaap1s,product_code=EPAYTEST', '8gBm/:&EnhH.1/q', true);
//        $signature = base64_encode($s);
//        $data = [
//            "amount" => "6",
//            "failure_url" => "https://marineaquatics.test/cart/checkout",
//            "product_delivery_charge" => "0",
//            "product_service_charge" => "0",
//            "product_code" => "EPAYTEST",
//            "signature" => $signature,
//            "signed_field_names" => "total_amount,transaction_uuid,product_code",
//            "success_url" => "https://marineaquatics.test/cart/success-order",
//            "tax_amount" => "0",
//            "total_amount" => "6",
//            "transaction_uuid" => "qsq3sdfaap1s"
//        ];
//
//        $url = 'https://rc-epay.esewa.com.np/api/epay/main/v2/form';
//
//        $ch = curl_init($url);
//
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
//
//        $response = curl_exec($ch);
//
//        if ($response === false) {
//            $error = curl_error($ch);
//        } else {
//            // If you want to capture the final URL after redirects, you can use the 'curl_getinfo' function
//            $resposneData = json_decode($response);
//            $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
//        }
//        curl_close($ch);
//        if ($finalUrl != $url) {
//            return Inertia::location($finalUrl);
//        } else {
//            return to_route('client.dashboard.order-history')->with('error', $resposneData->error_message);
//        }
//    }
}
