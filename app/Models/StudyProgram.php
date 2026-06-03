<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

#[Fillable(['name', 'slug', 'code', 'level', 'description', 'image', 'is_active', 'website_url'])]
class StudyProgram extends Model
{
    use HasFactory, LogsActivity;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($studyProgram) {
            if (empty($studyProgram->slug)) {
                $studyProgram->slug = Str::slug($studyProgram->name);
            }
        });

        static::updating(function ($studyProgram) {
            $studyProgram->slug = Str::slug($studyProgram->name);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
