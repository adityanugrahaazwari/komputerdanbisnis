<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class FrontendMenusSeeder extends Seeder
{
    public function run()
    {
        // Home
        Menu::updateOrCreate(
            ['url' => '/', 'location' => 'frontend'],
            ['title' => 'messages.home', 'order' => 1, 'is_active' => true]
        );

        // Profile Dropdown
        $profile = Menu::updateOrCreate(
            ['url' => '#', 'location' => 'frontend', 'order' => 2],
            ['title' => 'messages.profile', 'is_active' => true, 'icon' => 'fas fa-chevron-down']
        );

        Menu::updateOrCreate(['url' => '/profil#sejarah', 'location' => 'frontend'], ['title' => 'messages.history', 'parent_id' => $profile->id, 'order' => 1, 'is_active' => true]);
        Menu::updateOrCreate(['url' => '/profil#visi-misi', 'location' => 'frontend'], ['title' => 'messages.vision_mission', 'parent_id' => $profile->id, 'order' => 2, 'is_active' => true]);
        Menu::updateOrCreate(['url' => '/profil#struktur', 'location' => 'frontend'], ['title' => 'messages.structure', 'parent_id' => $profile->id, 'order' => 3, 'is_active' => true]);

        // Academic Dropdown
        $academic = Menu::updateOrCreate(
            ['url' => '#', 'location' => 'frontend', 'order' => 3],
            ['title' => 'messages.academic', 'is_active' => true, 'icon' => 'fas fa-chevron-down']
        );

        Menu::updateOrCreate(['url' => '/program-studi', 'location' => 'frontend'], ['title' => 'messages.study_programs', 'parent_id' => $academic->id, 'order' => 1, 'is_active' => true]);
        Menu::updateOrCreate(['url' => '/dosen', 'location' => 'frontend'], ['title' => 'messages.lecturers', 'parent_id' => $academic->id, 'order' => 2, 'is_active' => true]);
        Menu::updateOrCreate(['url' => '/layanan', 'location' => 'frontend'], ['title' => 'messages.services', 'parent_id' => $academic->id, 'order' => 3, 'is_active' => true]);

        // Information Dropdown
        $info = Menu::updateOrCreate(
            ['url' => '#', 'location' => 'frontend', 'order' => 4],
            ['title' => 'messages.information', 'is_active' => true, 'icon' => 'fas fa-chevron-down']
        );

        Menu::updateOrCreate(['url' => '/berita', 'location' => 'frontend'], ['title' => 'messages.news', 'parent_id' => $info->id, 'order' => 1, 'is_active' => true]);
        Menu::updateOrCreate(['url' => '/galeri', 'location' => 'frontend'], ['title' => 'messages.gallery', 'parent_id' => $info->id, 'order' => 2, 'is_active' => true]);
        Menu::updateOrCreate(['url' => '/downloads', 'location' => 'frontend'], ['title' => 'messages.downloads', 'parent_id' => $info->id, 'order' => 3, 'is_active' => true]);

        // Contact
        Menu::updateOrCreate(
            ['url' => '#kontak', 'location' => 'frontend'],
            ['title' => 'messages.contact', 'order' => 5, 'is_active' => true]
        );
    }
}
