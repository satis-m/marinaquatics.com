<?php

namespace Database\Seeders;

use App\Models\Category;
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
                    'category' => $category,
                    'sub_category' => $value->name,
                    'slug' => $value->slug,
                ]);
            }
        }
    }
}
