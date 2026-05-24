$komunikasi = \App\Models\Menu::firstOrCreate(
    ['title' => 'Komunikasi', 'location' => 'admin'],
    ['url' => '#', 'icon' => 'fas fa-comments', 'parent_id' => null, 'order' => 4, 'is_active' => 1]
);

$userAkses = \App\Models\Menu::firstOrCreate(
    ['title' => 'User & Hak Akses', 'location' => 'admin'],
    ['url' => '#', 'icon' => 'fas fa-users-cog', 'parent_id' => null, 'order' => 5, 'is_active' => 1]
);

// 2. Define updates
$updates = [
    // Profil Lembaga (parent 3)
    11 => ['parent_id' => 3, 'order' => 1], // Info Umum
    12 => ['parent_id' => 3, 'order' => 2], // Struktur
    13 => ['parent_id' => 3, 'order' => 3], // Program Studi
    21 => ['parent_id' => 3, 'order' => 4], // Layanan
    14 => ['parent_id' => 3, 'order' => 5], // Sosmed

    // Manajemen Konten (parent 2)
    10 => ['parent_id' => 2, 'order' => 1], // Berita
    20 => ['parent_id' => 2, 'order' => 2], // Kategori Berita
    15 => ['parent_id' => 2, 'order' => 3], // Galeri
    45 => ['parent_id' => 2, 'order' => 4], // Grup Galeri
    16 => ['parent_id' => 2, 'order' => 5], // Unduhan

    // Komunikasi (parent $komunikasi->id)
    18 => ['parent_id' => $komunikasi->id, 'order' => 1], // Inbox
    17 => ['parent_id' => $komunikasi->id, 'order' => 2], // Komentar
    40 => ['parent_id' => $komunikasi->id, 'order' => 3], // Pengumuman

    // User & Hak Akses (parent $userAkses->id)
    5 => ['parent_id' => $userAkses->id, 'order' => 1], // User
    6 => ['parent_id' => $userAkses->id, 'order' => 2], // Role
    7 => ['parent_id' => $userAkses->id, 'order' => 3], // Izin
    9 => ['parent_id' => $userAkses->id, 'order' => 4], // Grup Izin

    // Pengaturan Sistem (parent 4)
    42 => ['parent_id' => 4, 'order' => 1], // Identitas Situs
    41 => ['parent_id' => 4, 'order' => 2], // Tata Letak
    8  => ['parent_id' => 4, 'order' => 3], // Menu
    43 => ['parent_id' => 4, 'order' => 4], // Backup
    19 => ['parent_id' => 4, 'order' => 5], // Audit Logs
];

foreach ($updates as $id => $data) {
    \App\Models\Menu::where('id', $id)->update($data);
}

// 3. Update Root Menu Orders
\App\Models\Menu::where('id', 1)->update(['order' => 1]); // Dashboard
\App\Models\Menu::where('id', 3)->update(['order' => 2]); // Profil Lembaga
\App\Models\Menu::where('id', 2)->update(['order' => 3]); // Manajemen Konten
$komunikasi->update(['order' => 4]);
$userAkses->update(['order' => 5]);
\App\Models\Menu::where('id', 4)->update(['order' => 6]); // Pengaturan Sistem
\App\Models\Menu::where('id', 37)->update(['order' => 98]); // Profil Saya
\App\Models\Menu::where('id', 44)->update(['order' => 99]); // Manual Book

echo "Menus reorganized successfully!";