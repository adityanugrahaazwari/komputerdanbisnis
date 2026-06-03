<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Support\Str;

class CategoryMenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Permission Group exists
        $group = PermissionGroup::firstOrCreate(
            ['name' => 'Manajemen Konten'],
            ['slug' => Str::slug('Manajemen Konten')]
        );

        // 2. Ensure Permissions exist
        $permissions = [
            ['name' => 'View Categories', 'slug' => 'categories_view'],
            ['name' => 'Create Category', 'slug' => 'categories_create'],
            ['name' => 'Edit Category', 'slug' => 'categories_edit'],
            ['name' => 'Delete Category', 'slug' => 'categories_delete'],
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
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $admin->permissions()->syncWithoutDetaching(Permission::where('slug', 'like', 'categories_%')->pluck('id'));
        }

        // 4. Ensure Parent Menu exists
        $manajemenKonten = Menu::updateOrCreate(
            ['title' => 'Manajemen Konten', 'location' => 'admin'],
            ['url' => null, 'icon' => 'fas fa-edit', 'order' => 3, 'is_active' => 1]
        );

        // 5. Ensure Category Menu exists
        Menu::updateOrCreate(
            ['url' => '/categories'],
            [
                'title' => 'Kategori Berita',
                'icon' => 'fas fa-tags',
                'parent_id' => $manajemenKonten->id,
                'permission_slug' => 'categories_view',
                'order' => 2,
                'location' => 'admin',
                'is_active' => 1
            ]
        );
    }
}
