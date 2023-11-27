<?php

namespace App\Services;

use App\Models\ApplicationInfo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

class AppSettingService
{
    public function update()
    {
        try {
            $appsetting = ApplicationInfo::find(1);
            $appsetting->title = request('title');
            $appsetting->email = request('email');
            $appsetting->contact = request('contact');
            $appsetting->address = request('address');
            $appsetting->fb_link = request('fb_link');
            $appsetting->insta_link = request('insta_link');
            $appsetting->youtube_link = request('youtube_link');
            $appsetting->whatsapp_link = request('whatsapp_link');
            $appsetting->google_map = request('google_map');
            $appsetting->store_time = request('store_time');
            $appsetting->end_banner = request('end_banner');

            if (request()->has('logo') && request('logo') != '') {
                $appsetting->addMediaFromRequest('logo')->toMediaCollection('logo');
            }
            if (request()->has('favLight') && request('favLight') != '') {
                $appsetting->addMediaFromRequest('favLight')->toMediaCollection('fav-icon-light');
            }
            if (request()->has('favDark') && request('favDark') != '') {
                $appsetting->addMediaFromRequest('favDark')->toMediaCollection('fav-icon-dark');
            }
            Cache::forget('ApplicationInfo');
            return $appsetting->save();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }
}
