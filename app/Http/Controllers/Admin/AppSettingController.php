<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationInfo;
use App\Services\AppSettingService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AppSettingController extends Controller
{
    protected $permissionName = 'application-setting';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {
        $appInfo = ApplicationInfo::query()->first();

        return Inertia::render(
            'Admin/AppManagement/Index',
            [
                'breadcrumb' => readable('application-setting'),
                'appInfo' => $appInfo,
                'userCan' => [
                    'massAdd' => false && request()->user('admin')->hasPermissionTo($this->permissionName.'-create'),
                    'create' => request()->user('admin')->hasPermissionTo($this->permissionName.'-create'),
                    'edit' => request()->user('admin')->hasPermissionTo($this->permissionName.'-edit'),
                    'delete' => request()->user('admin')->hasPermissionTo($this->permissionName.'-delete'),
                ],
            ]
        );
    }

    public function update()
    {
        try {
            (new AppSettingService())->update();
        } catch (\Exception $e) {
            return Redirect::route('appSetting.index')->with('error', $e->getMessage());
        }

        return Redirect::route('appSetting.index')
            ->with('success', 'Application Information Updated Successfully');
    }
}
