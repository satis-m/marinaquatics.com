<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Importer;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Services\ProductService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    protected $permissionName = 'product';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {
        $categories = File::get(base_path('/storage/app/Category.json'));
        $categories = json_decode($categories);
        $subCategories = SubCategory::all()->groupBy(['category'])->toArray();
        $products = Product::with(['subCategory', 'comboOffer'])->latest()->get();
        $tags = Tag::get()->pluck('name')->toArray();
        $brands = Brand::get()->pluck('name')->toArray();
        $importers = Importer::get()->pluck('name')->toArray();

        return Inertia::render(
            'Admin/ProductManagement/Index',
            [
                'breadcrumb' => readable('application-setting'),
                'productList' => $products,
                'tags' => $tags,
                'brands' => $brands,
                'importers' => $importers,
                'categories' => $categories,
                'subCategories' => $subCategories,
                'userCan' => [
                    'massAdd' => false,
                    'create' => request()->user('admin')->hasPermissionTo($this->permissionName.'-create'),
                    'edit' => request()->user('admin')->hasPermissionTo($this->permissionName.'-edit'),
                    'delete' => request()->user('admin')->hasPermissionTo($this->permissionName.'-delete'),
                ],
            ]
        );
    }

    public function store(StoreProductRequest $request)
    {
        $request->validated();
        try {
            (new ProductService())->add();
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Added Successfully');
    }

    public function update(UpdateProductRequest $request, int $productId)
    {
        $request->validated();
        try {
            (new ProductService())->update($productId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Updated Successfully');
    }

    public function destroy(int $productId)
    {

        try {
            (new ProductService())->remove($productId);
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Deleted Successfully');
    }

    public function deletePicture(int $mediaId)
    {
        try {
            Media::where('id', $mediaId)->delete();
        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Deleted Successfully');
    }
}
