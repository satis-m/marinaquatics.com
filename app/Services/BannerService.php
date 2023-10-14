<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Support\Facades\File;

class BannerService
{
    public function update($bannerId)
    {
        $banner = Banner::find($bannerId);
        // Retrieve the uploaded file
        $banner->title = request('title');
        $banner->detail = request('detail');
        $banner->link = request('link');
        $banner->type = request('type');
        $banner->publish = request('publish');
        if (request()->file('file_path')) {
            request()->validate([
                'file_path' => 'file|mimes:jpg,png,webp,webm,mp4,gif',
            ]);
            if (File::exists(public_path($banner->file_path))) {
                File::delete(public_path($banner->file_path));
            }
            $fileName = time().'_'.request()->file('file_path')->getClientOriginalName();
            $filePath = request()->file('file_path')->storeAs('banners', $fileName, 'public');
            $banner->file_path = '/storage/'.$filePath;
            $banner->alt_image = '';
        }
        if (request()->file('alt_image') && request('type') == 'video') {
            if (File::exists(public_path($banner->alt_image))) {
                File::delete(public_path($banner->alt_image));
            }
            $fileName = time().'_'.request()->file('alt_image')->getClientOriginalName();
            $filePath = request()->file('alt_image')->storeAs('banners', $fileName, 'public');
            $banner->alt_image = '/storage/'.$filePath;
        }
        $banner->save();
    }
}
