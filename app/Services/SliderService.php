<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Support\Facades\File;

class SliderService
{
    public function update($sliderId)
    {
        $slider = Slider::find($sliderId);
        // Retrieve the uploaded file
        $slider->title = request('title');
        $slider->detail = request('detail');
        $slider->link = request('link');
        $slider->publish = request('publish');
        if (request()->file()) {
            request()->validate([
                'image' => 'file|mimes:jpg,png,webp|max:2048',
            ]);
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }
            $fileName = time().'_'.request()->file('image')->getClientOriginalName();
            $filePath = request()->file('image')->storeAs('sliders', $fileName, 'public');
            $slider->image = '/storage/'.$filePath;
        }
        $slider->save();
    }
}
