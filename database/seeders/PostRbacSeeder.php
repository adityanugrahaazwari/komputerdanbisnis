<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Post Permissions
        $permissions = [
            ['name' => 'View Posts', 'slug' => 'posts_view', 'group' => 'News'],
            ['name' => 'Create Post', 'slug' => 'posts_create', 'group' => 'News'],
            ['name' => 'Edit Post', 'slug' => 'posts_edit', 'group' => 'News'],
            ['name' => 'Delete Post', 'slug' => 'posts_delete', 'group' => 'News'],
            ['name' => 'Publish Post', 'slug' => 'posts_publish', 'group' => 'News'],
        ];

        foreach ($permissions as $perm) {
            $group = PermissionGroup::firstOrCreate(
                ['name' => $perm['group']],
                ['slug' => Str::slug($perm['group'])]
            );

            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'permission_group_id' => $group->id
                ]
            );
        }

        // 2. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $postPerms = Permission::whereIn('slug', array_column($permissions, 'slug'))->pluck('id');
            $adminRole->permissions()->syncWithoutDetaching($postPerms);
        }

        // 3. Assign limited permissions to Operator Role
        $operatorRole = Role::where('slug', 'operator')->first();
        if ($operatorRole) {
            $operatorPostPerms = Permission::whereIn('slug', [
                'posts_view',
                'posts_create',
                'posts_edit',
                'posts_delete'
            ])->pluck('id');
            $operatorRole->permissions()->syncWithoutDetaching($operatorPostPerms);
        }

        // 4. Create Menu
        Menu::updateOrCreate(
            ['url' => '/posts'],
            [
                'title' => 'Berita',
                'icon' => 'fas fa-newspaper',
                'permission_slug' => 'posts_view',
                'order' => 3
            ]
        );
    }
}
