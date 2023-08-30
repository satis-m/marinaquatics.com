<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        try {
            $wishlists = [];

            return Inertia::render('Wishlist/Index',
                [
                    'wishlists' => $wishlists,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }
}
