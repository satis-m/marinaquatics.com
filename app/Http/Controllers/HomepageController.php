<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomepageController extends Controller
{
    public function index()
    {
        $today = now();
        $discountProducts = Product::query()
            ->where('available_quantity', '>', 0)
            ->withlastImport()
            ->orderByLastImport()
            ->withCurrentDiscount()
            ->with('category')
            ->whereHas('discounts', function ($query) use ($today) {
                // Filter discounts based on your criteria, for example, check for an active status
                $query->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })
            ->take(20)
            ->get();

        $manProducts = Product::query()
            ->where('brand', 'man')
            ->withlastImport()
            ->orderByLastImport()
            ->withCurrentDiscount()
            ->with('category')
            ->take(20)
            ->get();

        $sliders = Cache::rememberForever('homeSliders', function () {
            return Slider::where('publish', 1)->get();
        });

        $banners = Cache::rememberForever('homeBanners', function () {
            return Banner::where('publish', 1)->get();
        });

        return Inertia::render('Home/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'discountProducts' => $discountProducts,
            'manProducts' => $manProducts,
            'sliders' => $sliders,
            'banners' => $banners,
        ]);
    }
}
