<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SocialMediaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Social Media
        $socials = [
            [
                'platform' => 'Facebook',
                'url' => 'https://facebook.com/komputerdanbisnis',
                'icon' => 'fab fa-facebook-f',
                'order' => 1
            ],
            [
                'platform' => 'Instagram',
                'url' => 'https://instagram.com/komputerdanbisnis',
                'icon' => 'fab fa-instagram',
                'order' => 2
            ],
            [
                'platform' => 'Twitter',
                'url' => 'https://twitter.com/kdb_tech',
                'icon' => 'fab fa-twitter',
                'order' => 3
            ],
            [
                'platform' => 'YouTube',
                'url' => 'https://youtube.com/c/komputerdanbisnis',
                'icon' => 'fab fa-youtube',
                'order' => 4
            ],
        ];

        foreach ($socials as $social) {
            SocialMedia::updateOrCreate(['platform' => $social['platform']], $social);
        }

        // 2. Create Permissions
        $permissions = [
            ['name' => 'View Social Media', 'slug' => 'social_media_view', 'group' => 'Web Profile'],
            ['name' => 'Create Social Media', 'slug' => 'social_media_create', 'group' => 'Web Profile'],
            ['name' => 'Edit Social Media', 'slug' => 'social_media_edit', 'group' => 'Web Profile'],
            ['name' => 'Delete Social Media', 'slug' => 'social_media_delete', 'group' => 'Web Profile'],
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

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(Permission::whereIn('slug', array_column($permissions, 'slug'))->pluck('id'));
        }

        // 4. Create Menu under "Profil Lembaga"
        $parent = Menu::where('title', 'Profil Lembaga')->first();
        Menu::updateOrCreate(
            ['url' => '/social-media'],
            [
                'title' => 'Media Sosial',
                'icon' => 'fas fa-share-alt',
                'parent_id' => $parent ? $parent->id : null,
                'permission_slug' => 'social_media_view',
                'order' => 3
            ]
        );
    }
}
