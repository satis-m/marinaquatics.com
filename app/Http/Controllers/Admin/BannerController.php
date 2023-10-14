<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BannerController extends Controller
{
    protected $permissionName = 'banner';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {
        $banners = Banner::all();

        return Inertia::render(
            'HomepageSetting/BannerIndex',
            [
                'breadcrumb' => readable('homepage-banner-setting'),
                'banners' => $banners,
            ]
        );
    }

    public function update($bannerId)
    {
        try {
            (new BannerService())->update($bannerId);
        } catch (\Exception $e) {
            return Redirect::route('admin.homepage-banner.index')->with('error', $e->getMessage());
        }
    }
}
