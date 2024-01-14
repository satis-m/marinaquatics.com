<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Blog extends Model implements HasMedia
{
    use SoftDeletes ,InteractsWithMedia;

    protected $appends = ['main_picture'];

    protected $casts = [
        'tag' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($blog) {
            $blog->slug = static::generateUniqueSlug($blog->title);
        });
    }

    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);

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

    public function getMainPictureAttribute()
    {
        $media = $this->getFirstMedia('blog_main_picture');
        if ($media != null) {
            $thumb = $main = $blur = $preview = $original = '';

            if ($media->hasGeneratedConversion('blur')) {
                $fullPath = $media->getPath('blur');
                if (file_exists($fullPath)) {
                    $blur = $media->getUrl('blur');
                }
            }
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

            if ($media->hasGeneratedConversion('original')) {
                $fullPath = $media->getPath('original');
                if (file_exists($fullPath)) {
                    $original = $media->getUrl('original');
                }
            }

            $fullPath = $media->getPath();
            if (file_exists($fullPath)) {
                $main = $media->getUrl();
            }

            return [
                'blur' => $blur,
                'thumbnail' => $thumb,
                'preview' => $preview,
                'original' => $original,
                'name' => $media->file_name,
                'id' => $media->id,
            ];
        }

        return null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blog_main_picture')
            ->acceptsMimeTypes(['image/jpeg', 'image/svg+xml', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 350, 150);

        $this->addMediaConversion('blur')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 35, 15)
            ->blur(2);

        $this->addMediaConversion('medium')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 602, 258);

        $this->addMediaConversion('original')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 1288, 552);
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereJsonContains('tag', [$search])
            ->orWhereFullText(['title', 'body', 'category'], $search, ['mode' => 'boolean'])
            ->orWhere('title', 'like', "%{$search}%");
    }

    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }
}
