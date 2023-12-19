<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class ProductSearchController extends Controller {

    public function __invoke() {
        try {
            $query = Product::query()
                            ->when(request('search'), function ($query, $search) {
                                $query->search($search);
                            });
            $products = $query->with('category')
                              ->withCurrentDiscount()
                              ->orderByDesc('available_quantity')
                              ->orderBy('products.name')
                              ->withlastImport()
                              ->paginate(12)
                              ->appends(request()->query());

            $products->map(function ($item) {
                $item->main_picture = $item->main_picture;

                return $item;
            });

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
