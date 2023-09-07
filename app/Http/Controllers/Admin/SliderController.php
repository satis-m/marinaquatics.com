<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    protected $permissionName = 'slider';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {

    }
}
