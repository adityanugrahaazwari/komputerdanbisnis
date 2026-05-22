<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class GalleryGroupMenuSeeder extends Seeder
{
    public function run(): void
    {
        $infoMenu = Menu::where('title', 'Informasi')->first();
        if ($infoMenu) {
            Menu::updateOrCreate(
                ['url' => '/gallery-groups'],
                [
                    'title' => 'Grup Galeri',
                    'icon' => 'fas fa-images',
                    'parent_id' => $infoMenu->id,
                    'permission_slug' => 'galleries_view',
                    'order' => 3, // Assuming Galleries is 4, Documents is 5
                    'is_active' => true,
                    'location' => 'admin'
                ]
            );
        }
    }
}
