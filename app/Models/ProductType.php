<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductType extends Model
{
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'type', 'slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'slug', 'sub_category');
    }

    protected static function booted(): void
    {
        static::creating(function ($productType) {
            $productType->slug = $productType->slug ?? static::generateUniqueSlug($productType->name);
        });
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);

        // Check if the slug already exists in the database
        $slugExists = static::where('slug', $slug)->exists();

        // If the slug exists, append a unique identifier until we find a unique slug
        $uniqueIdentifier = 1;
        while ($slugExists) {
            $newSlug = $slug.'-'.$uniqueIdentifier;
            $slugExists = static::where('slug', $newSlug)->exists();
            $uniqueIdentifier++;
        }

        return $newSlug ?? $slug;
    }
}
