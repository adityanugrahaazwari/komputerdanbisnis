<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait and register model observers.
     */
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('create', $model, "Membuat " . class_basename($model) . ": " . ($model->title ?? $model->name ?? $model->id));
        });

        static::updated(function ($model) {
            // Get changed attributes
            $changes = $model->getChanges();
            
            // Ignore timestamps
            unset($changes['updated_at']);

            if (empty($changes)) return;

            $model->logActivity('update', $model, "Memperbarui " . class_basename($model) . ": " . ($model->title ?? $model->name ?? $model->id), [
                'old' => array_intersect_key($model->getOriginal(), $changes),
                'new' => $changes,
            ]);
        });

        static::deleted(function ($model) {
            $model->logActivity('delete', $model, "Menghapus " . class_basename($model) . ": " . ($model->title ?? $model->name ?? $model->id));
        });
    }

    /**
     * Record an activity log entry.
     */
    public function logActivity($action, $subject = null, $description = null, $properties = [])
    {
        // Don't log if not authenticated (e.g. during seeding or console commands)
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
