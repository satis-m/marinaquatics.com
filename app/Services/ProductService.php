<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function add()
    {
        DB::beginTransaction();
        self::updateTagsAndBrands();

        try {
            $product = Product::create([
                'name' => request('name'),
                'sub_category' => request('sub_category'),
                'product_info' => request('product_info'),
                'description' => request('description'),
                'tag' => request('tag'),
                'brand' => request('brand'),
                'video_link' => request('video_link'),
                'publish' => request('publish'),
                'price' => request('price'),
            ]);
            if (request()->has('main_picture') && request('main_picture') != null) {
                $product->addMediaFromRequest('main_picture')->toMediaCollection('main_picture');
            }
            if (request()->has('alternative_picture') && request('alternative_picture') != null) {
                foreach (request('alternative_picture') as $image) {
                    $product->addMedia($image)->toMediaCollection('alternative_picture');
                }
            }

            DB::commit();

            return true;
        } catch (QueryException $e) {
            //database related exception
            DB::rollBack();

            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            //general exception
            DB::rollBack();

            return throw new \Exception($e->getMessage());
        }
    }

    public function update($id)
    {
        DB::beginTransaction();
        self::updateTagsAndBrands();
        try {
            $product = Product::find($id);
            $product->name = request('name');
            $product->sub_category = request('sub_category');
            $product->product_info = request('product_info');
            $product->description = request('description');
            $product->tag = request('tag');
            $product->brand = request('brand');
            $product->video_link = request('video_link');
            $product->publish = request('publish');
            $product->price = request('price');

            if (request()->has('main_picture') && request('main_picture') != '') {
                $product->addMediaFromRequest('main_picture')->toMediaCollection('main_picture');
            }
            if (request()->has('alternative_picture') && request('alternative_picture') != null) {
                foreach (request('alternative_picture') as $image) {
                    $product->addMedia($image)->toMediaCollection('alternative_picture');
                }
            }
            $product->save();
            DB::commit();

            return true;
        } catch (QueryException $e) {
            DB::rollBack();

            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            DB::rollBack();

            return throw new \Exception($e->getMessage());
        }
    }

    private function updateTagsAndBrands()
    {
        $tags = Tag::get()->pluck('name')->toArray();
        $brands = Brand::get()->pluck('name')->toArray();

        $newTags = array_diff(request('tag'), $tags);
        if (request('brand') != '' && ! in_array(request('brand'), $brands)) {
            Brand::create(['name' => request('brand')]);
        }

        if (! empty($newTags) || empty($tags)) {
            foreach ($newTags as $tag) {
                Tag::create(['name' => $tag]);
            }
        }
    }

    public function remove($id)
    {
        try {
            return Product::find($id)->delete();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }
}
