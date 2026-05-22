<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class ManualBookRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions
        $group = PermissionGroup::where('slug', 'system_settings')->first();
        if (!$group) {
            $group = PermissionGroup::create(['name' => 'System Settings', 'slug' => 'system_settings']);
        }

        $permission = Permission::updateOrCreate(
            ['slug' => 'manual_book_view'],
            ['name' => 'View Manual Book', 'permission_group_id' => $group->id]
        );

        // 2. Assign to Roles (Admin & Operator)
        $roles = Role::whereIn('slug', ['admin', 'operator'])->get();
        foreach ($roles as $role) {
            $role->permissions()->syncWithoutDetaching([$permission->id]);
        }

        // 3. Menu
        Menu::updateOrCreate(
            ['url' => '/manual-book'],
            [
                'title' => 'Manual Book',
                'icon' => 'fas fa-book',
                'parent_id' => null,
                'permission_slug' => 'manual_book_view',
                'order' => 100, // Put it at the bottom
                'is_active' => true,
                'location' => 'admin'
            ]
        );
    }
}
