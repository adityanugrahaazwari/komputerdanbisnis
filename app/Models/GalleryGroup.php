<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->name);
            }
        });

        static::updating(function ($group) {
            $group->slug = Str::slug($group->name);
        });
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
