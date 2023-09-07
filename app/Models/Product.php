<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
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
        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });
        static::created(function ($product) {
            ComboOffer::create([
                'product' => $product->slug,
                'name_1' => 'Standard',
                'quantity_1' => 1,
                'price_1' => $product->price,
            ]);
        });
        static::updated(function ($product) {
            ComboOffer::where('product', $product->slug)
                ->update([
                    'price_1' => $product->price,
                ]);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'sub_category', 'slug');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type', 'slug');
    }

    public function productImports()
    {
        return $this->hasMany(ProductImport::class, 'product', 'slug');
    }

    public function productDamages()
    {
        return $this->hasMany(ProductDamage::class, 'product', 'slug');
    }

    public function comboOffer()
    {
        return $this->hasOne(ComboOffer::class, 'product', 'slug');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product', 'slug');
    }

    protected $casts = [
        'tag' => 'array',
    ];

    public function getMainPictureAttribute()
    {

        if ($this->getFirstMedia('main_picture') != null) {
            $thumb = $main = $blur = $preview = '';
            $media = $this->getFirstMedia('main_picture');

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
            $fullPath = $media->getPath();
            if (file_exists($fullPath)) {
                $main = $media->getUrl();
            }

            return [
                'blur' => $blur,
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
                    $thumb = $pic = $blur = $preview = '';
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
                    $fullPath = $media->getPath('medium');

                    if (file_exists($fullPath)) {
                        $pic = $media->getUrl();
                    }

                    return [
                        'blur' => $blur,
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
            ->acceptsMimeTypes(['image/jpeg', 'image/svg+xml', 'image/png', 'image/webp'])
            ->singleFile();
        $this->addMediaCollection('alternative_picture')
            ->acceptsMimeTypes(['image/jpeg', 'image/svg+xml', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 250, 250)
            ->sharpen(10);

        $this->addMediaConversion('blur')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 30, 30)
            ->blur(2);

        $this->addMediaConversion('medium')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(600)
            ->height(600);
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

    public function currentDiscount()
    {
        return $this->hasOne(Discount::class, 'product', 'slug')
            ->whereDate('start_date', '<=', now()) // Discount start date should be less than or equal to the current date.
            ->whereDate('end_date', '>=', now()) // Discount end date should be greater than or equal to the current date.
            ->orderBy('id', 'desc')
            ->limit(1);
    }
}
