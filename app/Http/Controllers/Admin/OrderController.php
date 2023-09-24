<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    protected $permissionName = 'store-sell';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function store()
    {
        try {
            (new OrderService())->add();
        } catch (\Exception $e) {
            return Redirect::route('storeSell.list')->with('error', $e->getMessage());
        }

        return Redirect::route('storeSell.list')->with('success', 'Order Entered Successfully');

    }
}
