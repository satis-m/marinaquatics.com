<?php

namespace App\Http\Controllers;

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
}
