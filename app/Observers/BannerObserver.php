<?php

namespace App\Observers;

use App\Models\Banner;
use Illuminate\Support\Facades\Cache;

class BannerObserver
{
    public function created(Banner $product): void
    {
        Cache::forget('homeBanners');
    }

    public function updated(Banner $product): void
    {
        Cache::forget('homeBanners');
    }
}
