<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewFeaturesRbacSeeder extends Seeder
{
    public function run(): void
    {
        $newPermissions = [
            // Categories
            ['name' => 'View Categories', 'slug' => 'categories_view', 'group' => 'Manajemen Konten'],
            ['name' => 'Create Category', 'slug' => 'categories_create', 'group' => 'Manajemen Konten'],
            ['name' => 'Edit Category', 'slug' => 'categories_edit', 'group' => 'Manajemen Konten'],
            ['name' => 'Delete Category', 'slug' => 'categories_delete', 'group' => 'Manajemen Konten'],

            // Gallery
            ['name' => 'View Gallery', 'slug' => 'galleries_view', 'group' => 'Manajemen Konten'],
            ['name' => 'Create Gallery Item', 'slug' => 'galleries_create', 'group' => 'Manajemen Konten'],
            ['name' => 'Edit Gallery Item', 'slug' => 'galleries_edit', 'group' => 'Manajemen Konten'],
            ['name' => 'Delete Gallery Item', 'slug' => 'galleries_delete', 'group' => 'Manajemen Konten'],

            // Documents
            ['name' => 'View Documents', 'slug' => 'documents_view', 'group' => 'Manajemen Konten'],
            ['name' => 'Create Document', 'slug' => 'documents_create', 'group' => 'Manajemen Konten'],
            ['name' => 'Edit Document', 'slug' => 'documents_edit', 'group' => 'Manajemen Konten'],
            ['name' => 'Delete Document', 'slug' => 'documents_delete', 'group' => 'Manajemen Konten'],

            // Contacts
            ['name' => 'View Contacts', 'slug' => 'contacts_view', 'group' => 'Komunikasi'],
            ['name' => 'Delete Contact', 'slug' => 'contacts_delete', 'group' => 'Komunikasi'],

            // Comments
            ['name' => 'View Comments', 'slug' => 'comments_view', 'group' => 'Komunikasi'],
            ['name' => 'Edit/Moderate Comment', 'slug' => 'comments_edit', 'group' => 'Komunikasi'],
            ['name' => 'Delete Comment', 'slug' => 'comments_delete', 'group' => 'Komunikasi'],

            // Logs
            ['name' => 'View Activity Logs', 'slug' => 'logs_view', 'group' => 'Pengaturan Sistem'],
        ];

        foreach ($newPermissions as $perm) {
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

        // Assign all to Admin
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $admin->permissions()->syncWithoutDetaching(Permission::pluck('id'));
        }

        // Add Menus
        $contentMenu = Menu::where('title', 'Manajemen Konten')->first();
        if ($contentMenu) {
            Menu::updateOrCreate(['url' => '/posts'], ['title' => 'Berita & Artikel', 'icon' => 'fas fa-newspaper', 'parent_id' => $contentMenu->id, 'permission_slug' => 'posts_view', 'order' => 1]);
            Menu::updateOrCreate(['url' => '/categories'], ['title' => 'Kategori Berita', 'icon' => 'fas fa-tags', 'parent_id' => $contentMenu->id, 'permission_slug' => 'categories_view', 'order' => 2]);
            Menu::updateOrCreate(['url' => '/galleries'], ['title' => 'Galeri Foto', 'icon' => 'fas fa-images', 'parent_id' => $contentMenu->id, 'permission_slug' => 'galleries_view', 'order' => 3]);
            Menu::updateOrCreate(['url' => '/documents'], ['title' => 'Download Center', 'icon' => 'fas fa-file-download', 'parent_id' => $contentMenu->id, 'permission_slug' => 'documents_view', 'order' => 4]);
        }

        $commMenu = Menu::updateOrCreate(
            ['title' => 'Komunikasi & Interaksi'],
            ['url' => null, 'icon' => 'fas fa-comments', 'permission_slug' => null, 'order' => 5]
        );

        Menu::updateOrCreate(['url' => '/contacts'], ['title' => 'Pesan Masuk', 'icon' => 'fas fa-inbox', 'parent_id' => $commMenu->id, 'permission_slug' => 'contacts_view', 'order' => 1]);
        Menu::updateOrCreate(['url' => '/comments'], ['title' => 'Moderasi Komentar', 'icon' => 'fas fa-comment-dots', 'parent_id' => $commMenu->id, 'permission_slug' => 'comments_view', 'order' => 2]);

        $systemMenu = Menu::where('title', 'Pengaturan Sistem')->first();
        if ($systemMenu) {
            Menu::updateOrCreate(['url' => '/logs'], ['title' => 'Audit Logs', 'icon' => 'fas fa-history', 'parent_id' => $systemMenu->id, 'permission_slug' => 'logs_view', 'order' => 10]);
        }
    }
}
