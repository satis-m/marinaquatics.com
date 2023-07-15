<?php

namespace App\Services;

use App\Models\ApplicationInfo;
use Illuminate\Database\QueryException;

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

            if (request()->has('logo') && request('logo') != '') {
                $appsetting->addMediaFromRequest('logo')->toMediaCollection('logo');
            }
            if (request()->has('favLight') && request('favLight') != '') {
                $appsetting->addMediaFromRequest('favLight')->toMediaCollection('fav-icon-light');
            }
            if (request()->has('favDark') && request('favDark') != '') {
                $appsetting->addMediaFromRequest('favDark')->toMediaCollection('fav-icon-dark');
            }

            return $appsetting->save();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }
}
