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
                ->withlastImport()
                ->firstOrFail();

            $productInfo->main_picture = $productInfo->main_picture;
            $productInfo->alternative_picture = $productInfo->alternative_picture;

            $data['productInfo'] = $productInfo;
            //meta for seo of singel product
            $meta['og_meta'] = [
                'og_title' => $productInfo->name,
                'og_description' => $productInfo->name.' | '.htmlentities(strip_tags($productInfo->product_info)),
                'og_image' => $productInfo->main_picture['preview'],
                'og_url' => url()->current(),
            ];

            return Inertia::render('Product/SingleView/Index',$data)->withViewData($meta);
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
                'isLoggedIn' => auth('admin')->user(),
            ]);
    }

    public function categoryView($slug)
    {

        try {
            $query = Product::query()
                ->where('sub_category', $slug);
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            $products->map(function ($item) {
                $item->main_picture = $item->main_picture;

                return $item;
            });

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

    public function typeView($category,$slug)
    {

        try {
            $query = Product::query()
                ->where('sub_category', $category)
                ->where('type', $slug);
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            $products->map(function ($item) {
                $item->main_picture = $item->main_picture;

                return $item;
            });
            
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
            $products = $query->with('currentDiscount', 'category')
                ->paginate(10)
                ->appends(request()->query());

            $products->map(function ($item) {
                $item->main_picture = $item->main_picture;

                return $item;
            });
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

            $products->map(function ($item) {
                $item->main_picture = $item->main_picture;

                return $item;
            });
            
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
