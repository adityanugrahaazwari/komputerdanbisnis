<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'role', 'company', 'quote', 'image', 'is_active', 'order'])]
class Testimonial extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
