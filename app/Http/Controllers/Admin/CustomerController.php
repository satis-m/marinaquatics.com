<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Inertia\Inertia;

class CustomerController extends Controller {

    protected $permissionName = 'customer';

    public function __construct() {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index() {
        $customerList = Client::withSum(['orders' => function ($query) {
                                $query->where('order_status', '!=', 'cancelled');
                            }], 'total_amount')
                          ->get();
        return Inertia::render(
            'Customer/Index',
            [
                'breadcrumb' => readable('website-sales'),
                'customerList' => $customerList,
            ]
        );
    }

    public function updateStatus($clientId) {
        try{
            $client = Client::find($clientId);
            $client->status = request('status');
            $client->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Customer Account Status Updated Successfully');
    }
}
