<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

#[Fillable(['name', 'slug', 'nip', 'nidn', 'position', 'expertise', 'photo', 'email', 'google_scholar_url', 'sinta_url', 'study_program_id', 'order', 'is_active'])]
class Lecturer extends Model
{
    use HasFactory, LogsActivity;

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lecturer) {
            if (empty($lecturer->slug)) {
                $lecturer->slug = Str::slug($lecturer->name);
            }
        });

        static::updating(function ($lecturer) {
            $lecturer->slug = Str::slug($lecturer->name);
        });
    }
}
