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
        static::created(function ($model) {
            if (static::whereSlug($slug = Str::slug($model->name))->exists()) {
                $slug = "{$slug}-{$model->id}";
            }
            $model->update(['slug' => $slug]);
        });
    }
}
