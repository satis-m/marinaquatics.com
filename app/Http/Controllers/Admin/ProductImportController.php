<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;

class ProductImportController extends Controller
{
    protected $permissionName = 'product-import';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function store($productId)
    {
        try {
            (new ProductService())->addImport($productId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Added Successfully');
    }

    public function update($productId, $id)
    {
        try {
            (new ProductService())->updateImport($productId, $id);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Added Successfully');
    }
}
