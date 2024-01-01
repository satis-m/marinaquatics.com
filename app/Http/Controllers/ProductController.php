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
                ->with('category', 'comboOffer')
                ->withCurrentDiscount()
                ->withlastImport()
                ->firstOrFail();

            $data['productInfo'] = $productInfo;
            //meta for seo of singel product
            $meta['og_meta'] = [
                'og_title' => $productInfo->name,
                'og_description' => $productInfo->name.' | '.htmlentities(strip_tags($productInfo->product_info)),
                'og_image' => $productInfo->main_picture['preview'],
                'og_url' => url()->current(),
            ];

            return Inertia::render('Product/SingleView/Index', $data)->withViewData($meta);
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Product not found');
        }
    }

    public function categoryView($slug)
    {

        try {
            $query = Product::query()
                ->where('sub_category', $slug);
            $products = $query->with('category')
                ->withCurrentDiscount()
                ->withlastImport()
                ->orderByDesc('available_quantity')
                ->orderBy('products.name')
                ->paginate(12)
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

    public function typeView($category, $slug)
    {

        try {
            $query = Product::query()
                ->where('sub_category', $category)
                ->where('type', $slug);
            $products = $query->with('category')
                ->withCurrentDiscount()
                ->withlastImport()
                ->orderByDesc('available_quantity')
                ->orderBy('products.name')
                ->paginate(12)
                ->appends(request()->query());

            return Inertia::render('Product/TypeView/Index',
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
            $products = $query->with('category')
                ->withCurrentDiscount()
                ->withlastImport()
                ->paginate(12)
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
            $products = $query->with('category')
                ->withCurrentDiscount()
                ->withlastImport()
                ->paginate(12)
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
