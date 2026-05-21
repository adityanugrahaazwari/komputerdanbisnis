<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MissingMenusSeeder extends Seeder
{
    public function run()
    {
        // Manajemen Konten (ID 2)
        $contentMenuId = 2;

        Menu::updateOrCreate(
            ['url' => '/galleries'],
            [
                'title' => 'Galeri Foto',
                'icon' => 'fas fa-images',
                'parent_id' => $contentMenuId,
                'permission_slug' => 'galleries_view',
                'order' => 3,
                'is_active' => true
            ]
        );

        Menu::updateOrCreate(
            ['url' => '/documents'],
            [
                'title' => 'Pusat Unduhan',
                'icon' => 'fas fa-file-download',
                'parent_id' => $contentMenuId,
                'permission_slug' => 'documents_view',
                'order' => 4,
                'is_active' => true
            ]
        );

        Menu::updateOrCreate(
            ['url' => '/comments'],
            [
                'title' => 'Moderasi Komentar',
                'icon' => 'fas fa-comments',
                'parent_id' => $contentMenuId,
                'permission_slug' => 'comments_view',
                'order' => 5,
                'is_active' => true
            ]
        );

        Menu::updateOrCreate(
            ['url' => '/contacts'],
            [
                'title' => 'Inbox Pesan',
                'icon' => 'fas fa-envelope',
                'parent_id' => $contentMenuId,
                'permission_slug' => 'contacts_view',
                'order' => 6,
                'is_active' => true
            ]
        );

        // Pengaturan Sistem (ID 4)
        $systemMenuId = 4;

        Menu::updateOrCreate(
            ['url' => '/logs'],
            [
                'title' => 'Audit Logs',
                'icon' => 'fas fa-history',
                'parent_id' => $systemMenuId,
                'permission_slug' => 'logs_view',
                'order' => 6,
                'is_active' => true
            ]
        );
    }
}
