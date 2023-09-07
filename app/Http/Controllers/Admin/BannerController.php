<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    protected $permissionName = 'banner';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {

    }
}
