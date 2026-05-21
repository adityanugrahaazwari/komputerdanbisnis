<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class FrontendMenusSeeder extends Seeder
{
    public function run()
    {
        // Home
        Menu::create([
            'title' => 'messages.home',
            'url' => '/',
            'location' => 'frontend',
            'order' => 1,
            'is_active' => true
        ]);

        // Profile Dropdown
        $profile = Menu::create([
            'title' => 'messages.profile',
            'url' => '#',
            'location' => 'frontend',
            'order' => 2,
            'is_active' => true,
            'icon' => 'fas fa-chevron-down'
        ]);

        Menu::create(['title' => 'messages.history', 'url' => '/profil#sejarah', 'location' => 'frontend', 'parent_id' => $profile->id, 'order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'messages.vision & messages.mission', 'url' => '/profil#visi-misi', 'location' => 'frontend', 'parent_id' => $profile->id, 'order' => 2, 'is_active' => true]);
        Menu::create(['title' => 'messages.structure', 'url' => '/profil#struktur', 'location' => 'frontend', 'parent_id' => $profile->id, 'order' => 3, 'is_active' => true]);

        // Academic Dropdown
        $academic = Menu::create([
            'title' => 'Akademik',
            'url' => '#',
            'location' => 'frontend',
            'order' => 3,
            'is_active' => true,
            'icon' => 'fas fa-chevron-down'
        ]);

        Menu::create(['title' => 'messages.study_programs', 'url' => '/program-studi', 'location' => 'frontend', 'parent_id' => $academic->id, 'order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'messages.services', 'url' => '/layanan', 'location' => 'frontend', 'parent_id' => $academic->id, 'order' => 2, 'is_active' => true]);

        // Information Dropdown
        $info = Menu::create([
            'title' => 'Informasi',
            'url' => '#',
            'location' => 'frontend',
            'order' => 4,
            'is_active' => true,
            'icon' => 'fas fa-chevron-down'
        ]);

        Menu::create(['title' => 'messages.news', 'url' => '/berita', 'location' => 'frontend', 'parent_id' => $info->id, 'order' => 1, 'is_active' => true]);
        Menu::create(['title' => 'messages.gallery', 'url' => '/galeri', 'location' => 'frontend', 'parent_id' => $info->id, 'order' => 2, 'is_active' => true]);
        Menu::create(['title' => 'messages.downloads', 'url' => '/downloads', 'location' => 'frontend', 'parent_id' => $info->id, 'order' => 3, 'is_active' => true]);

        // Contact
        Menu::create([
            'title' => 'messages.contact',
            'url' => '#kontak',
            'location' => 'frontend',
            'order' => 5,
            'is_active' => true
        ]);
    }
}
