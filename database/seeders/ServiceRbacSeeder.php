<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Support\Str;

class ServiceRbacSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Permission Group
        $group = PermissionGroup::firstOrCreate(
            ['name' => 'Services'],
            ['slug' => 'services']
        );

        // 2. Create Permissions
        $perms = [
            ['name' => 'View Services', 'slug' => 'services_view'],
            ['name' => 'Create Service', 'slug' => 'services_create'],
            ['name' => 'Edit Service', 'slug' => 'services_edit'],
            ['name' => 'Delete Service', 'slug' => 'services_delete'],
        ];

        $allPermIds = [];
        foreach ($perms as $perm) {
            $permission = Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'permission_group_id' => $group->id
                ]
            );
            $allPermIds[] = $permission->id;
        }

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching($allPermIds);
        }

        // 4. Add to Sidebar Menu (Manajemen Konten)
        $contentMenu = Menu::where('title', 'Manajemen Konten')->first();
        if ($contentMenu) {
            Menu::updateOrCreate(
                ['url' => '/services'],
                [
                    'title' => 'Layanan Luar',
                    'icon' => 'fas fa-external-link-alt',
                    'parent_id' => $contentMenu->id,
                    'permission_slug' => 'services_view',
                    'order' => 7,
                    'is_active' => true
                ]
            );
        }
    }
}
