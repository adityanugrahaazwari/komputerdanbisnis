<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

#[Fillable(['user_id', 'title', 'message', 'type', 'target_role', 'is_active'])]
class Announcement extends Model
{
    use HasFactory, LogsActivity;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $user)
    {
        if (!$user) {
            return $query->where('target_role', 'all');
        }

        $roleSlugs = $user->roles->pluck('slug')->toArray();
        $roleSlugs[] = 'all';

        return $query->whereIn('target_role', $roleSlugs);
    }
}
