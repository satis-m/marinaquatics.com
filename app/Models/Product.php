<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'products';

    protected $guarded = [];

    protected $appends = ['main_picture', 'alternative_picture'];

    protected static function booted(): void
    {
        static::created(function ($model) {
            if (static::whereSlug($slug = Str::slug($model->sub_categoty))->exists()) {
                $slug = "{$slug}-{$model->id}";
            }
            $model->update(['slug' => $slug]);
        });
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category', 'slug');
    }

    protected $casts = [
        'tag' => 'array',
    ];

    public function getMainPictureAttribute()
    {
        if ($this->getFirstMedia('main_picture') != null) {
            $thumb = $main = $preview = '';
            $media = $this->getFirstMedia('main_picture');

            if ($media->hasGeneratedConversion('thumb')) {
                $fullPath = $media->getPath('thumb');
                if (file_exists($fullPath)) {
                    $thumb = $media->getUrl('thumb');
                }
            }
            if ($media->hasGeneratedConversion('medium')) {
                $fullPath = $media->getPath('medium');
                if (file_exists($fullPath)) {
                    $preview = $media->getUrl('medium');
                }
            }
            $fullPath = $media->getPath();
            if (file_exists($fullPath)) {
                $main = $media->getUrl();
            }

            return [
                'thumbnail' => $thumb,
                'preview' => $preview,
                'original' => $main,
                'name' => $media->file_name,
                'id' => $media->id,
            ];
        }

        return null;
    }

    public function getAlternativePictureAttribute()
    {
        if ($this->getMedia('alternative_picture')->count()) {
            return $this->getMedia('alternative_picture')
                ->map(function (Media $media) {
                    $thumb = $pic = $preview = '';
                    if ($media->hasGeneratedConversion('thumb')) {
                        $fullPath = $media->getPath('thumb');
                        if (file_exists($fullPath)) {
                            $thumb = $media->getUrl('thumb');
                        }
                    }
                    if ($media->hasGeneratedConversion('medium')) {
                        $fullPath = $media->getPath('medium');
                        if (file_exists($fullPath)) {
                            $preview = $media->getUrl('medium');
                        }
                    }
                    $fullPath = $media->getPath('medium');

                    if (file_exists($fullPath)) {
                        $pic = $media->getUrl();
                    }

                    return [
                        'thumbnail' => $thumb,
                        'original' => $pic,
                        'preview' => $preview,
                        'name' => $media->file_name,
                        'id' => $media->id,
                    ];
                });
        }

        return null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_picture')
            ->acceptsMimeTypes(['image/jpeg', 'image/svg+xml', 'image/png'])
            ->singleFile();
        $this->addMediaCollection('alternative_picture')
            ->acceptsMimeTypes(['image/jpeg', 'image/svg+xml', 'image/png']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(600);
    }
}
