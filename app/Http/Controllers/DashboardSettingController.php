<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\DashboardSetting;
use Illuminate\Http\Request;

class DashboardSettingController extends Controller
{
    public function index()
    {
        $this->authorizePermission('dashboard_settings_edit');
        $roles = Role::with('dashboardSetting')->get();
        
        // Ensure each role has a dashboard setting record
        foreach ($roles as $role) {
            if (!$role->dashboardSetting) {
                DashboardSetting::create(['role_id' => $role->id]);
            }
        }
        
        $roles = Role::with('dashboardSetting')->get();
        return view('dashboard_settings.index', compact('roles'));
    }

    public function update(Request $request)
    {
        $this->authorizePermission('dashboard_settings_edit');
        
        $settings = $request->input('settings', []);
        
        foreach ($settings as $roleId => $values) {
            DashboardSetting::updateOrCreate(
                ['role_id' => $roleId],
                [
                    'show_stats' => isset($values['show_stats']),
                    'show_announcements' => isset($values['show_announcements']),
                    'show_recent_posts' => isset($values['show_recent_posts']),
                    'show_recent_interactions' => isset($values['show_recent_interactions']),
                    'show_system_logs' => isset($values['show_system_logs']),
                    'show_academic_info' => isset($values['show_academic_info']),
                    'show_my_activity' => isset($values['show_my_activity']),
                ]
            );
        }

        return back()->with('success', 'Dashboard settings updated successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
