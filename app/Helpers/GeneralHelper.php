<?php

use App\Models\Admin;
use App\Models\ApplicationInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

if (! \function_exists('executeMax')) {
    function executeMax($limit = 10)
    {
        set_time_limit($limit);
    }
}
if (! \function_exists('suffix')) {
    function suffix($number)
    {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number.'th';
        } else {
            return $number.$ends[$number % 10];
        }
    }
}
if (! \function_exists('getPercent')) {
    function getPercent($obtain, $total)
    {
        return round(($obtain / $total) * 100, 2);
    }
}
if (! \function_exists('getAppInfo')) {
    function getAppInfo($key = '')
    {
        $appInfo = Cache::rememberForever('ApplicationInfo', function () {
            return ApplicationInfo::first();
        });

        if ($key != '') {
            return $appInfo->$key;
        }

        return $appInfo;
    }
}

if (! \function_exists('getPortalMenu')) {
    function getPortalMenu($guard = 'admin')
    {
        if (Auth::guard($guard)->check()) {
            $menuList = File::get(storage_path('required/menu.json'));
            $roles = json_decode(Auth::guard($guard)->user()->roles()->pluck('name'));
            $role = reset($roles);
            $menus = json_decode($menuList);
            if (property_exists($menus, $role)) {
                $menu = $menus->$role->menu;
            } else {
                throw new Exception('Role Menu not Assigned');
            }

            return json_encode($menu);
        }

        return abort(403, 'User is not logged');
    }
}

if (! \function_exists('file_name_info')) {
    function file_name_info($value = '')
    {
        $all_info = explode('/', $value);
        $info['file_name'] = end($all_info);
        $info['name'] = current(explode('.', $info['file_name']));

        return $info;
    }
}
if (! \function_exists('make_file')) {
    function make_file($filepath, $information)
    {
        Storage::disk('local')->put($filepath, $information);
    }
}
if (! \function_exists('read_file')) {
    function read_file($filepath)
    {
        try {
            $contents = File::get($filepath);

            return $contents;
        } catch (Illuminate\Contracts\Filesystem\FileNotFoundException $exception) {
            throw new Exception('File Not Found');
        }
    }
}
if (! \function_exists('arrayFlipMapping')) {
    function arrayFlipMapping($source, $options)
    {
        $options = array_flip(explode(',', $options));

        return array_intersect_key($source, $options);
    }
}
if (! \function_exists('objectToArray')) {
    function objectToArray($object)
    {
        if (! \is_object($object) && ! \is_array($object)) {
            return $object;
        }

        return array_map('objectToArray', (array) $object);
    }
}
if (! \function_exists('arrayKeyFlatten')) {
    function arrayKeyFlatten($MenuArray, $keys)
    {
        $output = [];
        if (\is_array($MenuArray)) {
            array_walk_recursive($MenuArray, function ($value, $key) use (&$output, &$keys) {
                if ($key === $keys) {
                    $output[] = $value;
                }
            });

            return $output;
        }

        return $output;
    }
}
if (! \function_exists('previousRoute')) {
    /**
     * Generate a route name for the previous request.
     *
     * @return string|null
     */
    function previousRoute()
    {
        $previousRequest = app('request')->create(app('url')->previous());
        try {
            $routeName = app('router')->getRoutes()->match($previousRequest)->getName();
        } catch (NotFoundHttpException $exception) {
            return null;
        }

        return $routeName;
    }
}
if (! \function_exists('glue')) {
    function glue($array, $glue = ' '): string
    {
        return implode($glue, array_filter($array, 'strlen'));
    }
}
/**
 * Dynamically set the database provided option temporarily
 *
 * @param  mixed  $option
 * database config option
 * @param $state
 * database config state
 * @return bool true if provided setting is implemented,
 * false otherwise
 */
if (! \function_exists('dbDynamic')) {
    function dbDynamic($option, $state)
    {
        config([$option => $state]);
        DB::purge(env('DB_CONNECTION'));

        return DB::reconnect(env('DB_CONNECTION'));
    }
}
if (! \function_exists('dumpSql')) {
    function dumpSql($query)
    {
        return dd(Str::replaceArray('?', $query->getBindings(), $query->toSql()));
    }
}
if (! \function_exists('getSql')) {
    function getSql($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }
}
if (! \function_exists('arrayFilter')) {
    function arrayFilter($dataArray, $filterKey)
    {
        $filteredArray = [];
        foreach ($dataArray as $value) {
            $filteredArray[] = $value[$filterKey];
        }

        return $filteredArray;
    }
}
if (! \function_exists('urlExists')) {
    function urlExists($url): bool
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);

        return $status;
    }
}
if (! \function_exists('fileExists')) {
    function fileExists($file)
    {
        $str = str_replace(env('APP_URL').'/', '', $file);

        return file_exists($str);
    }
}
if (! \function_exists('resetAutoIncrement')) {
    function resetAutoIncrement($db_table): void
    {
        DB::unprepared("SET  @num := 0; UPDATE {$db_table} SET id = @num := (@num+1); ALTER TABLE {$db_table} AUTO_INCREMENT =1;");
    }
}
if (! \function_exists('update_env')) {
    function update_env($data = []): void
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                file_put_contents($path, str_replace(
                    $key.'='.env($key),
                    $key.'='.$value,
                    file_get_contents($path)
                ));
            }
        }
    }
}
if (! \function_exists('getDistrict')) {
    function getDistrict()
    {
        $districtList = File::get(storage_path('required/districts.json'));

        return json_encode(json_decode($districtList));
    }
}
if (! \function_exists('getCountry')) {
    function getCountry()
    {
        $countryList = File::get(storage_path('required/countries.json'));

        return json_encode(json_decode($countryList));
    }
}

if (! \function_exists('generateUsername')) {
    function generateUsername($userName): string
    {
        $username = $userName;
        $i = 0;
        while (Admin::whereUsername($username)->exists()) {
            $i++;
            $username = $userName.$i;
        }

        return $username;
    }
}

if (! \function_exists('sendMail')) {
    function sendMail($to_name, $to_email, $subject, $templateData)
    {
        return Mail::send('emails.mail', $templateData, function ($message) use ($to_name, $to_email, $subject) {
            $message->to($to_email, $to_name)->subject($subject);
            $message->from('No-Reply.amabuba@gmail.com', 'No-Reply');
        });
    }
}
//if (!\function_exists('getBreadcrumb')) {
//    function getBreadcrumb()
//    {
//        $routeName = Route::current()->getName();
//        $menuLink = MenuLink::where('link', $routeName)->first();
//        if ($menuLink != null) {
//            return $menuLink->type == 'child' ? $menuLink->parentName . ' / ' . $menuLink->name : $menuLink->name;
//        }
//        return null;
//    }
//}

if (! \function_exists('readable')) {
    function readable($string): string
    {
        $words = str_replace(['-', '_'], ' ', $string);
        $escapedCamel = strtolower(preg_replace('/(?<!^)[A-Z]/', ' $0', $words));

        return ucwords(
            preg_replace(
                '~(\s|\x{3164})+~u',
                ' ',
                preg_replace(
                    '~^[\s﻿]+|[\s﻿]+$~u',
                    '',
                    $escapedCamel
                )
            )
        );
    }
}

if (! \function_exists('isAuthorized')) {
    function isAuthorized($role): bool
    {
        $userRole = Auth::user()->roles[0]->name;
        if (\is_array($role)) {
            return \in_array(strtolower($userRole), array_map('strtolower', $role));
        }

        return strtolower($userRole) == strtolower($role);
    }
}

if (! \function_exists('get_guard')) {
    function get_guard()
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        } elseif (Auth::guard('client')->check()) {
            return 'client';
        }
    }
}

if (! \function_exists('sanitizer')) {
    function sanitizer($inputString): string
    {
        // Remove '.' and ',' characters
        $cleanedString = str_replace(['.', ','], '', $inputString);
        // Replace multiple spaces with a single space
        $cleanedString = preg_replace('/\s+/', ' ', $cleanedString);

        return $cleanedString;
    }
}
if (! \function_exists('otpGenerate')) {
    function otpGenerate($length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz'; // You can include other characters if needed
        $otp = '';

        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $otp;
    }
}
if (! \function_exists('generateUniqueOrderNumber')) {
    function generateUniqueOrderNumber($length = 6): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        do {
            $orderNumber = '';

            for ($i = 0; $i < $length; $i++) {
                $orderNumber .= $characters[rand(0, $charactersLength - 1)];
            }
            $orderNumber = date('ym').'-'.$orderNumber;
            // Check if the order number is already used
            $isUnique = ! \DB::table('orders')->where('order_no', $orderNumber)->exists();
        } while (! $isUnique);

        return $orderNumber;
    }
}

if (! \function_exists('blogCategories')) {
    function blogCategories(): object
    {
        return (object) [
            'beginner-advice' => 'Beginner Advice',
            'betta-fish' => 'Betta Fish',
            'breeding' => 'Breeding',
            'disease-and-care-guide' => 'Disease & Care Guide',
            'goldfish' => 'Goldfish',
            'planted-tanks' => 'Planted Tanks',
            'filtration' => 'Filtration',
            'tank-maintenance' => 'Tank Maintenance',
            'water-parameters' => 'Water Parameters',
        ];
    }
}
