<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['platform', 'url', 'icon', 'is_active', 'order'])]
class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media';
}
