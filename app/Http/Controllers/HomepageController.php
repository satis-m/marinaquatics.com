<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomepageController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('available_quantity', '>', 0)
            ->withlastImport()
            ->orderByLastImport()
            ->with('currentDiscount', 'category')
            ->get()
            ->take(20)
            ->transform(function ($item) {
                $item->main_picture = $item->main_picture;
                $item->alternative_picture = $item->alternative_picture;

                return $item;
            });
        $sliders = Cache::rememberForever('homeSliders', function () {
            return Slider::where('publish', 1)->get();
        });

        $banners = Cache::rememberForever('homeBanners', function () {
            return Banner::where('publish', 1)->get();
        });

        return Inertia::render('Home/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'products' => $products,
            'sliders' => $sliders,
            'banners' => $banners,
        ]);
    }
}
