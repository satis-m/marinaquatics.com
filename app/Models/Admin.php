<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, HasRoles, InteractsWithMedia;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_pic',
        'profile_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['avatar', 'fullName'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.($this->middle_name ? $this->middle_name.' ' : '').$this->last_name;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->acceptsMimeTypes(['image/jpeg'])
            ->singleFile();
    }

    public function getAvatarAttribute()
    {
        if ($this->getFirstMedia('avatar') != null) {
            $fullPath = $this->getFirstMedia('avatar')->getPath('thumb');
            if (file_exists($fullPath)) {
                return $this->getFirstMedia('avatar')->getUrl('thumb');
            }
        }

        return null;
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
