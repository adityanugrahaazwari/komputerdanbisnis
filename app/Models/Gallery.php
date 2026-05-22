<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['gallery_group_id', 'title', 'image', 'description', 'order', 'is_active'];

    public function group()
    {
        return $this->belongsTo(GalleryGroup::class, 'gallery_group_id');
    }
}
