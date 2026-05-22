<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;
use App\Models\DashboardSetting;

class DashboardSettingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions
        $group = PermissionGroup::where('slug', 'announcements')->first(); // Reuse or create
        if (!$group) {
            $group = PermissionGroup::create(['name' => 'System Settings', 'slug' => 'system_settings']);
        }

        Permission::updateOrCreate(
            ['slug' => 'dashboard_settings_edit'],
            ['name' => 'Edit Dashboard Settings', 'permission_group_id' => $group->id]
        );

        // 2. Assign to Admin
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->attach(Permission::where('slug', 'dashboard_settings_edit')->first()->id);
        }

        // 3. Initial Settings for each Role
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            DashboardSetting::updateOrCreate(['role_id' => $admin->id], [
                'show_stats' => true,
                'show_announcements' => true,
                'show_recent_posts' => true,
                'show_recent_interactions' => true,
                'show_system_logs' => true,
                'show_academic_info' => true,
                'show_my_activity' => false,
            ]);
        }

        $operator = Role::where('slug', 'operator')->first();
        if ($operator) {
            DashboardSetting::updateOrCreate(['role_id' => $operator->id], [
                'show_stats' => false,
                'show_announcements' => true,
                'show_recent_posts' => true,
                'show_recent_interactions' => false,
                'show_system_logs' => false,
                'show_academic_info' => true,
                'show_my_activity' => true,
            ]);
        }

        // 4. Menu
        $systemMenu = Menu::where('title', 'Pengaturan Sistem')->first();
        Menu::updateOrCreate(
            ['url' => '/dashboard-settings'],
            [
                'title' => 'Tata Letak Dashboard',
                'icon' => 'fas fa-th-large',
                'parent_id' => $systemMenu ? $systemMenu->id : null,
                'permission_slug' => 'dashboard_settings_edit',
                'order' => 8,
                'is_active' => true,
                'location' => 'admin'
            ]
        );
    }
}
