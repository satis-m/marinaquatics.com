<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subCategories = File::get(base_path('/storage/required/SubCategory.json'));
        $subCategories = json_decode($subCategories);
        foreach ($subCategories as $category => $subCategory) {
            foreach ($subCategory as $value) {
                Category::create([
                    'name' => $category,
                    'sub_category' => $value->name,
                    'slug' => $value->slug,
                ]);
                foreach ($value->types as $type) {
                    ProductType::create([
                        'sub_category' => $value->slug,
                        'name' => $type->name,
                        'slug' => $type->slug,
                    ]);
                }
            }
        }
    }
}
