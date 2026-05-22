<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Support\Str;

class AnnouncementRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Permission Group
        $group = PermissionGroup::updateOrCreate(
            ['name' => 'Announcements'],
            ['slug' => 'announcements']
        );

        // 2. Create Permissions
        $permissions = [
            ['name' => 'View Announcements', 'slug' => 'announcements_view'],
            ['name' => 'Create Announcement', 'slug' => 'announcements_create'],
            ['name' => 'Edit Announcement', 'slug' => 'announcements_edit'],
            ['name' => 'Delete Announcement', 'slug' => 'announcements_delete'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'permission_group_id' => $group->id
                ]
            );
        }

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(
                Permission::where('slug', 'like', 'announcements_%')->pluck('id')
            );
        }

        // 4. Create Menu
        $systemMenu = Menu::where('title', 'Pengaturan Sistem')->first();
        Menu::updateOrCreate(
            ['url' => '/announcements'],
            [
                'title' => 'Broadcast Pengumuman',
                'icon' => 'fas fa-bullhorn',
                'parent_id' => $systemMenu ? $systemMenu->id : null,
                'permission_slug' => 'announcements_view',
                'order' => 7,
                'is_active' => true,
                'location' => 'admin'
            ]
        );
    }
}
