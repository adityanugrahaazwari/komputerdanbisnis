<?php
use App\Models\Menu;

$galeri = Menu::updateOrCreate(
    ['title' => 'Manajemen Galeri', 'location' => 'admin'],
    [
        'icon' => 'fas fa-images',
        'parent_id' => 2,
        'order' => 5,
        'is_active' => true,
        'url' => null
    ]
);

Menu::where('title', 'Galeri Foto')->update(['parent_id' => $galeri->id, 'order' => 1]);
Menu::where('title', 'Grup Galeri')->update(['parent_id' => $galeri->id, 'order' => 2]);

echo "Menus reorganized successfully.";
