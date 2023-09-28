<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Services\SliderService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SliderController extends Controller
{
    protected $permissionName = 'slider';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {
        $sliders = Slider::all();

        return Inertia::render(
            'HomepageSetting/SliderIndex',
            [
                'breadcrumb' => readable('homepage-slider-setting'),
                'sliders' => $sliders,
            ]
        );
    }

    public function update($sliderId)
    {
        try {
            (new SliderService())->update($sliderId);
        } catch (\Exception $e) {
            return Redirect::route('admin.homepage-slider.index')->with('error', $e->getMessage());
        }
    }
}
