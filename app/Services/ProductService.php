<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Importer;
use App\Models\Product;
use App\Models\ProductDamage;
use App\Models\ProductImport;
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
                'tag' => array_map('sanitizer', request('tag')),
                'brand' => request('brand'),
                'video_link' => request('video_link'),
                'publish' => request('publish'),
                'price' => request('price'),
                'unit' => request('unit'),
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
            $product->tag = array_map('sanitizer', request('tag'));
            $product->brand = request('brand');
            $product->video_link = request('video_link');
            $product->publish = request('publish');
            $product->price = request('price');
            $product->unit = request('unit');

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

        $brand = sanitizer(request('brand'));
        $newTags = array_diff(array_map('sanitizer', request('tag')), $tags);

        if ($brand != '' && ! in_array($brand, $brands)) {
            Brand::create(['name' => $brand]);
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

    private function updateImporters()
    {
        $importers = Importer::get()->pluck('name')->toArray();
        $importer = sanitizer(request('importer'));
        if ($importer != '' && ! in_array($importer, $importers)) {
            Importer::create(['name' => $importer]);
        }
    }

    public function addImport($productId)
    {
        DB::beginTransaction();
        self::updateImporters();

        try {
            $created = ProductImport::create([
                'importer' => sanitizer(request('importer')),
                'quantity' => request('quantity'),
                'cost_price' => request('cost_price'),
                'product' => $productId,
            ]);
            if ($created) {
                $info = [
                    'action' => 'add',
                    'previous_quantity' => 0,
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productId, $info);
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

    public function updateImport($productId, $id)
    {
        DB::beginTransaction();
        self::updateImporters();
        try {
            $updated = ProductImport::where('id', $id)
                ->update([
                    'importer' => sanitizer(request('importer')),
                    'quantity' => request('quantity'),
                    'cost_price' => request('cost_price'),
                    'product' => $productId,
                ]);
            if ($updated) {
                $info = [
                    'action' => 'add',
                    'previous_quantity' => 0,
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productId, $info);
            }
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

    public function addDamage($productId)
    {
        DB::beginTransaction();
        try {
            $created = ProductDamage::create([
                'importer' => sanitizer(request('importer')),
                'quantity' => request('quantity'),
                'cost_price' => request('cost_price'),
                'remark' => request('remark'),
                'product' => $productId,
            ]);
            if ($created) {
                $info = [
                    'action' => 'remove',
                    'previous_quantity' => 0,
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productId, $info);
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

    public function updateDamage($productId, $id)
    {
        DB::beginTransaction();
        try {
            $updated = ProductDamage::where('id', $id)
                ->update([
                    'importer' => sanitizer(request('importer')),
                    'quantity' => request('quantity'),
                    'cost_price' => request('cost_price'),
                    'remark' => request('remark'),
                    'product' => $productId,
                ]);

            if ($updated) {
                $info = [
                    'action' => 'remove',
                    'previous_quantity' => request('prev_quantity'),
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productId, $info);
            }
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

    public function updateProductQuantity($product_id, $info)
    {
        $product = Product::where('slug', $product_id)->first();
        if ($info['action'] == 'add') {
            $product->available_quantity = (int) $product->available_quantity + (int) $info['quantity'];
        } else {
            $product->available_quantity = (int) $product->available_quantity + (int) $info['previous_quantity'] - (int) $info['quantity'];
        }

        return $product->save();
    }
}
