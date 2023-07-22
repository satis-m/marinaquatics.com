<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($subCategory) {
            $subCategory->slug = static::generateUniqueSlug($subCategory->name);
        });
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);

        // Check if the slug already exists in the database
        $slugExists = static::withTrashed()->where('slug', $slug)->exists();

        // If the slug exists, append a unique identifier until we find a unique slug
        $uniqueIdentifier = 1;
        while ($slugExists) {
            $newSlug = $slug.'-'.$uniqueIdentifier;
            $slugExists = static::withTrashed()->where('slug', $newSlug)->exists();
            $uniqueIdentifier++;
        }

        return $newSlug ?? $slug;
    }
}
