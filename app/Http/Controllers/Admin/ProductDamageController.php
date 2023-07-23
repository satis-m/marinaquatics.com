<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;

class ProductDamageController extends Controller
{
    protected $permissionName = 'product-damage';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function store($productId)
    {
        try {
            (new ProductService())->addDamage($productId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Added Successfully');
    }

    public function update($productId, $damageId)
    {
        try {
            (new ProductService())->updateDamage($productId, $damageId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Added Successfully');
    }
}
