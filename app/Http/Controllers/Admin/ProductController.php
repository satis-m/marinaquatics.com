<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Importer;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Tag;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;
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
        $categories = File::get(base_path('/storage/required/Category.json'));
        $categories = json_decode($categories);
        $subCategories = Cache::rememberForever('productCategory', function () {
            return Category::all()->groupBy(['name'])->toArray();
        });
        $products = Product::with(['category', 'comboOffer'])->latest()->get()->map(function ($item) {
            $item->main_picture = $item->main_picture;
            $item->alternative_picture = $item->alternative_picture;

            return $item;
        });
        $tags = Tag::get()->pluck('name')->toArray();
        $brands = Brand::get()->pluck('name')->toArray();
        $importers = Importer::get()->pluck('name')->toArray();

        $productTypes = Cache::rememberForever('productType', function () {
            ProductType::all()->groupBy(['sub_category'])->toArray();
        });

        return Inertia::render(
            'ProductManagement/Index',
            [
                'breadcrumb' => readable('manage-product'),
                'productList' => $products,
                'tags' => $tags,
                'brands' => $brands,
                'importers' => $importers,
                'categories' => $categories,
                'productTypes' => $productTypes,
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
            $media = Media::where('id', $mediaId)->first();
            $product = Product::find($media->model_id);
            $mediaItem = $product->getMedia($media->collection_name)->where('id', $media->id)->first();
            if ($mediaItem) {
                $mediaItem->delete();
            }

        } catch (\Exception $e) {
            return Redirect::route('product.index')->with('error', $e->getMessage());
        }

        return Redirect::route('product.index')->with('success', 'Deleted Successfully');
    }
}
