<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class AccountMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parent = Menu::updateOrCreate(
            ['title' => 'Profil Saya', 'location' => 'admin'],
            [
                'url' => null,
                'icon' => 'fas fa-user-circle',
                'parent_id' => null,
                'order' => 5,
                'is_active' => true,
            ]
        );

        // Delete old one if exists
        Menu::where('title', 'Pengaturan Akun')->where('location', 'admin')->delete();

        Menu::updateOrCreate(
            ['url' => '/account/profile', 'location' => 'admin'],
            [
                'title' => 'Edit Profil',
                'icon' => 'fas fa-user-edit',
                'parent_id' => $parent->id,
                'order' => 1,
                'is_active' => true,
            ]
        );

        Menu::updateOrCreate(
            ['url' => '/account/password', 'location' => 'admin'],
            [
                'title' => 'Ubah Password',
                'icon' => 'fas fa-key',
                'parent_id' => $parent->id,
                'order' => 2,
                'is_active' => true,
            ]
        );
    }
}
