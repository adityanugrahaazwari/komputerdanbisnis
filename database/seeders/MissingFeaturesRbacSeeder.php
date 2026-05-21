<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Support\Str;

class MissingFeaturesRbacSeeder extends Seeder
{
    public function run()
    {
        $features = [
            'Gallery' => [
                ['name' => 'View Gallery', 'slug' => 'galleries_view'],
                ['name' => 'Create Gallery', 'slug' => 'galleries_create'],
                ['name' => 'Edit Gallery', 'slug' => 'galleries_edit'],
                ['name' => 'Delete Gallery', 'slug' => 'galleries_delete'],
            ],
            'News' => [
                ['name' => 'View Categories', 'slug' => 'categories_view'],
                ['name' => 'Create Category', 'slug' => 'categories_create'],
                ['name' => 'Edit Category', 'slug' => 'categories_edit'],
                ['name' => 'Delete Category', 'slug' => 'categories_delete'],
            ],
            'Documents' => [
                ['name' => 'View Documents', 'slug' => 'documents_view'],
                ['name' => 'Create Documents', 'slug' => 'documents_create'],
                ['name' => 'Edit Documents', 'slug' => 'documents_edit'],
                ['name' => 'Delete Documents', 'slug' => 'documents_delete'],
            ],
            'Interactions' => [
                ['name' => 'View Comments', 'slug' => 'comments_view'],
                ['name' => 'Approve Comments', 'slug' => 'comments_approve'],
                ['name' => 'Reject/Spam Comments', 'slug' => 'comments_reject'],
                ['name' => 'Delete Comments', 'slug' => 'comments_delete'],
                ['name' => 'View Contacts/Messages', 'slug' => 'contacts_view'],
                ['name' => 'Delete Contacts/Messages', 'slug' => 'contacts_delete'],
            ],
            'System Management' => [
                ['name' => 'View Audit Logs', 'slug' => 'logs_view'],
            ]
        ];

        $allNewPermIds = [];

        foreach ($features as $groupName => $perms) {
            $group = PermissionGroup::firstOrCreate(
                ['name' => $groupName],
                ['slug' => Str::slug($groupName)]
            );

            foreach ($perms as $perm) {
                $permission = Permission::updateOrCreate(
                    ['slug' => $perm['slug']],
                    [
                        'name' => $perm['name'],
                        'permission_group_id' => $group->id
                    ]
                );
                $allNewPermIds[] = $permission->id;
            }
        }

        // Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching($allNewPermIds);
        }

        // Ensure Menu entries are correct (Mirroring MissingMenusSeeder but safer here)
        $contentMenu = Menu::where('title', 'Manajemen Konten')->first();
        if ($contentMenu) {
            Menu::updateOrCreate(['url' => '/posts'], ['title' => 'Berita & Artikel', 'icon' => 'fas fa-newspaper', 'parent_id' => $contentMenu->id, 'permission_slug' => 'posts_view', 'order' => 1]);
            Menu::updateOrCreate(['url' => '/categories'], ['title' => 'Kategori Berita', 'icon' => 'fas fa-tags', 'parent_id' => $contentMenu->id, 'permission_slug' => 'categories_view', 'order' => 2]);
            Menu::updateOrCreate(['url' => '/galleries'], ['title' => 'Galeri Foto', 'icon' => 'fas fa-images', 'parent_id' => $contentMenu->id, 'permission_slug' => 'galleries_view', 'order' => 3]);
            Menu::updateOrCreate(['url' => '/documents'], ['title' => 'Pusat Unduhan', 'icon' => 'fas fa-file-download', 'parent_id' => $contentMenu->id, 'permission_slug' => 'documents_view', 'order' => 4]);
            Menu::updateOrCreate(['url' => '/comments'], ['title' => 'Moderasi Komentar', 'icon' => 'fas fa-comments', 'parent_id' => $contentMenu->id, 'permission_slug' => 'comments_view', 'order' => 5]);
            Menu::updateOrCreate(['url' => '/contacts'], ['title' => 'Inbox Pesan', 'icon' => 'fas fa-envelope', 'parent_id' => $contentMenu->id, 'permission_slug' => 'contacts_view', 'order' => 6]);
        }

        $systemMenu = Menu::where('title', 'Pengaturan Sistem')->first();
        if ($systemMenu) {
            Menu::updateOrCreate(['url' => '/logs'], ['title' => 'Audit Logs', 'icon' => 'fas fa-history', 'parent_id' => $systemMenu->id, 'permission_slug' => 'logs_view', 'order' => 6]);
        }
    }
}
