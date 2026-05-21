<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class PermissionGroupRbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = PermissionGroup::where('name', 'Access Control')->first();
        if (!$group) {
            $group = PermissionGroup::create(['name' => 'Access Control', 'slug' => 'access-control']);
        }

        $permissions = [
            ['name' => 'View Permission Groups', 'slug' => 'permission_groups_view'],
            ['name' => 'Create Permission Groups', 'slug' => 'permission_groups_create'],
            ['name' => 'Edit Permission Groups', 'slug' => 'permission_groups_edit'],
            ['name' => 'Delete Permission Groups', 'slug' => 'permission_groups_delete'],
        ];

        $newPermIds = [];
        foreach ($permissions as $perm) {
            $permission = Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                ['name' => $perm['name'], 'permission_group_id' => $group->id]
            );
            $newPermIds[] = $permission->id;
        }

        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $admin->permissions()->syncWithoutDetaching($newPermIds);
        }

        // 3. Create Menu under "RBAC Management"
        $rbacMenu = Menu::where('title', 'RBAC Management')->first();
        if ($rbacMenu) {
            // Adjust orders for other RBAC submenus
            Menu::where('parent_id', $rbacMenu->id)->where('order', '>=', 4)->increment('order');
            
            Menu::updateOrCreate(
                ['url' => '/permission-groups'],
                [
                    'title' => 'Permission Groups',
                    'icon' => 'fas fa-layer-group',
                    'parent_id' => $rbacMenu->id,
                    'permission_slug' => 'permission_groups_view',
                    'order' => 4,
                    'is_active' => true
                ]
            );
        }
    }
}
