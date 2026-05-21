<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class OrganizationalStructureRbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = PermissionGroup::where('name', 'Web Profile')->first();
        if (!$group) {
            $group = PermissionGroup::create(['name' => 'Web Profile', 'slug' => 'web-profile']);
        }

        $permissions = [
            ['name' => 'View Organizational Structure', 'slug' => 'organizational_structures_view'],
            ['name' => 'Create Organizational Structure', 'slug' => 'organizational_structures_create'],
            ['name' => 'Edit Organizational Structure', 'slug' => 'organizational_structures_edit'],
            ['name' => 'Delete Organizational Structure', 'slug' => 'organizational_structures_delete'],
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

        // 3. Create Menu under "Profil Web"
        $profileMenu = Menu::where('title', 'Profil Web')->first();
        if ($profileMenu) {
            Menu::updateOrCreate(
                ['url' => '/organizational-structures'],
                [
                    'title' => 'Struktur Organisasi',
                    'icon' => 'fas fa-sitemap',
                    'parent_id' => $profileMenu->id,
                    'permission_slug' => 'organizational_structures_view',
                    'order' => 1,
                    'is_active' => true
                ]
            );
        }
    }
}
