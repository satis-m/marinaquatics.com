<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function view($slug)
    {
        try {
            $productInfo = Product::query()
                ->where('slug', $slug)
                ->with('currentDiscount', 'category', 'comboOffer')
                ->firstOrFail();

            return Inertia::render('Product/SingleView/Index',
                [
                    'productInfo' => $productInfo,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }

    public function list($subCategory)
    {
        $products = Product::query()
            ->where('sub_category', $subCategory)
            ->orderBy('slug')
            ->with('media', 'currentDiscount')
            ->get();

        return Inertia::render(
            'Product/List',
            [
                'products' => $products,
                'isLoggedIn' => auth()->user(),
            ]);
        dd($products);
    }

    public function categoryView($slug)
    {

        try {
            $query = Product::query()
                ->where('sub_category', $slug);
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            return Inertia::render('Product/CategoryView/Index',
                [
                    'products' => $products,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }

    public function typeView($slug)
    {

        try {
            $query = Product::query()
                ->where('type', $slug);
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            return Inertia::render('Product/CategoryView/Index',
                [
                    'products' => $products,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }

    public function brandView($slug)
    {

        try {
            $query = Product::query()
                ->where('brand', $slug);
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            return Inertia::render('Product/CategoryView/Index',
                [
                    'products' => $products,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }

    public function tagView($slug)
    {

        try {
            $query = Product::query()
                ->whereJsonContains('tag', $slug);
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            return Inertia::render('Product/CategoryView/Index',
                [
                    'products' => $products,
                ]
            );
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }
}
