<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class BackupRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions
        $group = PermissionGroup::where('slug', 'system_settings')->first();
        if (!$group) {
            $group = PermissionGroup::create(['name' => 'System Settings', 'slug' => 'system_settings']);
        }

        $permissions = [
            ['name' => 'View Backups', 'slug' => 'backups_view'],
            ['name' => 'Create Backups', 'slug' => 'backups_create'],
            ['name' => 'Delete Backups', 'slug' => 'backups_delete'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                ['name' => $perm['name'], 'permission_group_id' => $group->id]
            );
        }

        // 2. Assign to Admin
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(
                Permission::whereIn('slug', ['backups_view', 'backups_create', 'backups_delete'])->pluck('id')
            );
        }

        // 3. Menu
        $systemMenu = Menu::where('title', 'Pengaturan Sistem')->first();
        Menu::updateOrCreate(
            ['url' => '/backups'],
            [
                'title' => 'Pencadangan Data',
                'icon' => 'fas fa-hdd',
                'parent_id' => $systemMenu ? $systemMenu->id : null,
                'permission_slug' => 'backups_view',
                'order' => 9,
                'is_active' => true,
                'location' => 'admin'
            ]
        );
    }
}
