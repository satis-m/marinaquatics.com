<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class ProductSearchController extends Controller
{
    public function __invoke()
    {
        try {
            $query = Product::query()
                ->when(request('search'), function ($query, $search) {
                    $query->search($search);
                }, function ($query) {
                    $query->latest();
                });
            $products = $query->whereHas('category')
                ->with('currentDiscount', 'category')
                ->paginate(20)
                ->appends(request()->query());

            return Inertia::render('Product/SearchView/Index',
                [
                    'products' => $products,
                    'filters' => request()->only('search'),
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }
}
