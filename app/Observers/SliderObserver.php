<?php

namespace App\Observers;

use App\Models\Slider;
use Illuminate\Support\Facades\Cache;

class SliderObserver
{
    public function created(Slider $product): void
    {
        Cache::forget('homeSliders');
    }

    public function updated(Slider $product): void
    {
        Cache::forget('homeSliders');
    }
}
