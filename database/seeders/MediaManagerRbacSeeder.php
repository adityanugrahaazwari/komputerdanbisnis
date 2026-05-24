<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class MediaManagerRbacSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Permission Group if not exists
        $group = PermissionGroup::firstOrCreate(
            ['slug' => 'media'],
            ['name' => 'Media Management']
        );

        // 2. Create Permissions
        $permission = Permission::updateOrCreate(
            ['slug' => 'media_view'],
            [
                'name' => 'View Media Manager',
                'permission_group_id' => $group->id
            ]
        );

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching([$permission->id]);
        }

        // 4. Add to Sidebar Menu (Manajemen Konten)
        /*
        $contentMenu = Menu::where('title', 'Manajemen Konten')->first();
        if ($contentMenu) {
            Menu::updateOrCreate(
                ['url' => '/laravel-filemanager?type=Images'],
                [
                    'title' => 'Manajer Media',
                    'icon' => 'fas fa-photo-video',
                    'parent_id' => $contentMenu->id,
                    'permission_slug' => 'media_view',
                    'order' => 9,
                    'is_active' => true
                ]
            );
        }
        */
    }
}
