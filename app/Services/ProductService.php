<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\ComboOffer;
use App\Models\Discount;
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
                'tag' => ! empty(request('tag')) ? array_map('sanitizer', request('tag')) : '',
                'brand' => request('brand'),
                'type' => request('type'),
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

    public function update($productId)
    {
        DB::beginTransaction();
        self::updateTagsAndBrands();
        try {
            $product = Product::find($productId);
            $product->name = request('name');
            $product->sub_category = request('sub_category');
            $product->product_info = request('product_info');
            $product->description = request('description');
            $product->tag = request('tag') ? array_map('sanitizer', request('tag')) : '';
            $product->brand = request('brand');
            $product->type = request('type');
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
        if (! empty(request('tag'))) {
            $tags = Tag::get()->pluck('name')->toArray();

            $newTags = array_diff(array_map('sanitizer', request('tag')), $tags);

            if (! empty($newTags) || empty($tags)) {
                foreach ($newTags as $tag) {
                    Tag::create(['name' => $tag]);
                }
            }
        }
        if (request('brand') != '') {
            $brands = Brand::get()->pluck('name')->toArray();
            $brand = sanitizer(request('brand'));
            if ($brand != '' && ! in_array($brand, $brands)) {
                Brand::create(['name' => $brand]);
            }
        }

    }

    public function remove($productId)
    {
        try {
            return Product::find($productId)->delete();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    public function destroy($productId)
    {
        try {
            return Product::withTrashed()->find($productId)->forceDelete();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    public function restore($productId)
    {
        try {
            return Product::withTrashed()->find($productId)->restore();
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

    public function addImport($productSlug)
    {
        DB::beginTransaction();
        self::updateImporters();

        try {
            $created = ProductImport::create([
                'importer' => sanitizer(request('importer')),
                'quantity' => request('quantity'),
                'cost_price' => request('cost_price'),
                'product_slug' => $productSlug,
            ]);
            if ($created) {
                $info = [
                    'action' => 'add',
                    'previous_quantity' => 0,
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productSlug, $info);
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

    public function updateImport($productSlug, $importId)
    {
        DB::beginTransaction();
        self::updateImporters();
        try {
            $updated = ProductImport::where('id', $importId)
                ->update([
                    'importer' => sanitizer(request('importer')),
                    'quantity' => request('quantity'),
                    'cost_price' => request('cost_price'),
                    'product_slug' => $productSlug,
                ]);
            if ($updated) {
                $info = [
                    'action' => 'update',
                    'previous_quantity' => request('prev_quantity'),
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productSlug, $info);
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

    public function addDamage($productSlug)
    {
        DB::beginTransaction();
        try {
            $created = ProductDamage::create([
                'importer' => sanitizer(request('importer')),
                'quantity' => request('quantity'),
                'cost_price' => request('cost_price'),
                'remark' => request('remark'),
                'product_slug' => $productSlug,
            ]);
            if ($created) {
                $info = [
                    'action' => 'remove',
                    'previous_quantity' => 0,
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productSlug, $info);
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

    public function updateDamage($productSlug, $damageId)
    {
        DB::beginTransaction();
        try {
            $updated = ProductDamage::where('id', $damageId)
                ->update([
                    'importer' => sanitizer(request('importer')),
                    'quantity' => request('quantity'),
                    'cost_price' => request('cost_price'),
                    'remark' => request('remark'),
                    'product_slug' => $productSlug,
                ]);

            if ($updated) {
                $info = [
                    'action' => 'remove',
                    'previous_quantity' => request('prev_quantity'),
                    'quantity' => request('quantity'),
                ];
                self::updateProductQuantity($productSlug, $info);
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

    public function updateProductQuantity($productSlug, $info)
    {
        $product = Product::where('slug', $productSlug)->first();
        if ($info['action'] == 'add') {
            $product->available_quantity = (int) $product->available_quantity + (int) $info['quantity'];
        } elseif ($info['action'] == 'update') {
            $product->available_quantity = (int) $product->available_quantity - (int) $info['previous_quantity'] + (int) $info['quantity'];
        } else {
            $product->available_quantity = (int) $product->available_quantity + (int) $info['previous_quantity'] - (int) $info['quantity'];
        }

        return $product->save();
    }

    public function updateOffer($productSlug)
    {
        DB::beginTransaction();
        self::updateImporters();
        try {
            ComboOffer::where('product_slug', $productSlug)
                ->update([
                    'name_1' => sanitizer(request('name_1')),
                    'quantity_1' => request('quantity_1'),
                    'price_1' => request('price_1'),
                    'name_2' => sanitizer(request('name_2')),
                    'quantity_2' => request('quantity_2'),
                    'price_2' => request('price_2'),
                    'name_3' => sanitizer(request('name_3')),
                    'quantity_3' => request('quantity_3'),
                    'price_3' => request('price_3'),

                ]);
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

    public function addDiscount($productSlug)
    {
        DB::beginTransaction();
        try {
            Discount::create([
                'discount' => request('discount'),
                'start_date' => request('date')[0],
                'end_date' => request('date')[1],
                'remark' => sanitizer(request('remark')),
                'product_slug' => $productSlug,
            ]);
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

    public function updateDiscount($productSlug, $discountId)
    {
        DB::beginTransaction();
        try {
            Discount::find($discountId)->update([
                'discount' => request('discount'),
                'start_date' => request('date')[0],
                'end_date' => request('date')[1],
                'remark' => sanitizer(request('remark')),
            ]);
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
}
