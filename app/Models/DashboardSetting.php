<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['role_id', 'show_stats', 'show_announcements', 'show_recent_posts', 'show_recent_interactions', 'show_system_logs', 'show_academic_info', 'show_my_activity'])]
class DashboardSetting extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
