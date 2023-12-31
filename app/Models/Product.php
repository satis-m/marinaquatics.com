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

    protected $casts = [
        'tag' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });
        static::created(function ($product) {
            ComboOffer::create([
                'product_slug' => $product->slug,
                'name_1' => 'Standard',
                'quantity_1' => 1,
                'price_1' => $product->price,
            ]);
        });
        static::updated(function ($product) {
            ComboOffer::where('product_slug', $product->slug)
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
        return $this->hasMany(ProductImport::class, 'product_slug', 'slug');
    }

    public function productDamages()
    {
        return $this->hasMany(ProductDamage::class, 'product_slug', 'slug');
    }

    public function comboOffer()
    {
        return $this->hasOne(ComboOffer::class, 'product_slug', 'slug');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_slug', 'slug');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_slug', 'slug');
    }

    public function getMainPictureAttribute()
    {
        $media = $this->getFirstMedia('main_picture');
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

    public function getAlternativePictureAttribute()
    {
        $altImage = $this->getMedia('alternative_picture');
        if ($altImage->count()) {
            return $altImage
                ->map(function (Media $media) {
                    $thumb = $pic = $blur = $preview = $original = '';
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

                    $fullPath = $media->getPath('medium');

                    if (file_exists($fullPath)) {
                        $pic = $media->getUrl();
                    }

                    return [
                        'blur' => $blur,
                        'thumbnail' => $thumb,
                        'original' => $original,
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
            ->crop(Manipulations::CROP_CENTER, 350, 350);

        $this->addMediaConversion('blur')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 30, 30)
            ->blur(2);

        $this->addMediaConversion('medium')
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 600, 600)
            ->watermark(storage_path('/required/watermark.png'))
            ->watermarkHeight('10', '%')
            ->watermarkwidth('100', '%')
            ->watermarkPosition('left')
            ->watermarkFit('stretch')
            ->watermarkOpacity('36');

        $this->addMediaConversion('original')
            ->format(Manipulations::FORMAT_WEBP)
            ->watermark(storage_path('/required/watermark.png'))
            ->watermarkHeight('10', '%')
            ->watermarkwidth('100', '%')
            ->watermarkPosition('left')
            ->watermarkFit('stretch')
            ->watermarkOpacity('36');
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
        return $this->belongsTo(Discount::class);
    }

    public function scopeWithCurrentDiscount($query)
    {
        $query->addSelect(['current_discount_id' => Discount::select('id')
            ->whereColumn('product_slug', 'products.slug')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('id', 'desc')
            ->take(1),
        ])->with('currentDiscount');
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereJsonContains('tag', [$search])
            ->orWhereFullText(['name', 'product_info', 'type', 'sub_category'], $search, ['mode' => 'boolean'])
            ->orWhere('name', 'like', "%{$search}%");
    }

    public function lastImport()
    {
        return $this->belongsTo(ProductImport::class);
    }

    public function scopeWithLastImport($query)
    {
        $query->addSelect(['last_import_id' => ProductImport::select('id')
            ->whereColumn('product_slug', 'products.slug')
            ->latest()
            ->take(1),

        ])->with('lastImport:created_at,id');
    }

    public function scopeOrderByLastImport($query)
    {
        $query->orderByDesc(ProductImport::select('created_at')
            ->whereColumn('product_slug', 'products.slug')
            ->latest()
            ->take(1)
        );
    }
}
