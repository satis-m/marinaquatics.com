<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        try {
            $userCart = [];

            return Inertia::render('Cart/Index',
                [
                    'userCart' => $userCart,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }

    public function store()
    {
        try {
            $cartId = Cart::firstOrCreate(['customer_id' => auth('client')->user()->id])->first()->id;
            $itemExist = self::productExist($cartId, request('product_slug'));
            if($itemExist == null)
            {
                CartItem::create([
                    'cart_id' => $cartId,
                    'product_slug' => request('product_slug'),
                    'quantity' => request('quantity'),
                    'offer_name' => request('offer')['name'],
                    'offer_quantity' => request('offer')['quantity'],
                    'offer_price' => request('offer')['price'],
                ]);
            }
            else{
                if(strtolower($itemExist->offer_name) == strtolower(request('offer')['name']) )
                {
                    CartItem::query()
                            ->where('id',$itemExist->id)
                            ->where('cart_id', $itemExist->cart_id)
                            ->update(['quantity' => (int)$itemExist->quantity + (int)request('quantity')]);
                }
                else
                {
                    return redirect()->back()->with('error', 'Item already exist in cart with different offer');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product added to Cart Successfully');
    }

    public function update()
    {
        $cartId = Cart::where(['customer_id' => auth('client')->user()->id])->first()->id;
        if(request('quantity') > 0)
        {
            CartItem::query()
            ->where('id',request('itemId'))
            ->where('cart_id',$cartId)
            ->update(['quantity' => request('quantity')]);
        }
        else
        {
           return self::destroy();
        }
        return redirect()->back()->with('success', 'Cart updated Successfully');

    }

    public function destroy()
    {
        $cartId = Cart::where(['customer_id' => auth('client')->user()->id])->first()->id;
        try {
            CartItem::query()
                    ->where('id',request('itemId'))
                    ->where('cart_id',$cartId)
                    ->delete();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product removed From Cart Successfully');
    }

    public function productExist($cartId, $productSlug) {
        return CartItem::query()
        ->where('product_slug',$productSlug)
        ->where('cart_id',$cartId)
        ->first();
    }
}
