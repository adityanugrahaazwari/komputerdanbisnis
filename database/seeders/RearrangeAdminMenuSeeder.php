<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;

class RearrangeAdminMenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Definisikan Parent Menu (Root)
        // Order:
        // 1. Dashboard
        // 2. Profil Lembaga
        // 3. Manajemen Konten
        // 4. Komunikasi
        // 5. User & Hak Akses
        // 6. Pengaturan Sistem
        // 98. Profil Saya
        // 99. Manual Book

        $dashboard = Menu::where('url', '/dashboard')->first();
        if ($dashboard) $dashboard->update(['order' => 1]);

        $profilLembaga = Menu::updateOrCreate(
            ['title' => 'Profil Lembaga', 'location' => 'admin'],
            ['url' => null, 'icon' => 'fas fa-university', 'order' => 2, 'is_active' => 1]
        );

        $manajemenKonten = Menu::updateOrCreate(
            ['title' => 'Manajemen Konten', 'location' => 'admin'],
            ['url' => null, 'icon' => 'fas fa-edit', 'order' => 3, 'is_active' => 1]
        );

        $komunikasi = Menu::updateOrCreate(
            ['title' => 'Komunikasi', 'location' => 'admin'],
            ['url' => null, 'icon' => 'fas fa-comments', 'order' => 4, 'is_active' => 1]
        );

        $userAkses = Menu::updateOrCreate(
            ['title' => 'User & Hak Akses', 'location' => 'admin'],
            ['url' => null, 'icon' => 'fas fa-users-cog', 'order' => 5, 'is_active' => 1]
        );

        $pengaturanSistem = Menu::updateOrCreate(
            ['title' => 'Pengaturan Sistem', 'location' => 'admin'],
            ['url' => null, 'icon' => 'fas fa-cogs', 'order' => 6, 'is_active' => 1]
        );

        $profilSaya = Menu::where('title', 'Profil Saya')->first();
        if ($profilSaya) $profilSaya->update(['order' => 98]);

        $manualBook = Menu::where('title', 'Manual Book')->first();
        if ($manualBook) $manualBook->update(['order' => 99]);

        // 2. Susun Sub-Menu

        // --- Profil Lembaga ---
        $this->moveMenu('/profiles', 'Informasi Umum', 'fas fa-info-circle', $profilLembaga->id, 1);
        $this->moveMenu('/organizational-structures', 'Struktur Organisasi', 'fas fa-sitemap', $profilLembaga->id, 2);
        $this->moveMenu('/study-programs', 'Program Studi', 'fas fa-graduation-cap', $profilLembaga->id, 3);
        $this->moveMenu('/lecturers', 'Dosen & Staf', 'fas fa-users', $profilLembaga->id, 4);
        $this->moveMenu('/services', 'Layanan', 'fas fa-concierge-bell', $profilLembaga->id, 5);
        $this->moveMenu('/social-media', 'Media Sosial', 'fas fa-share-alt', $profilLembaga->id, 6);
        $this->moveMenu('/testimonials', 'Testimoni', 'fas fa-quote-left', $profilLembaga->id, 7);

        // --- Manajemen Konten ---
        $this->moveMenu('/posts', 'Berita & Artikel', 'fas fa-newspaper', $manajemenKonten->id, 1);
        $this->moveMenu('/categories', 'Kategori Berita', 'fas fa-tags', $manajemenKonten->id, 2);
        $this->moveMenu('/galleries', 'Galeri Foto', 'fas fa-images', $manajemenKonten->id, 3);
        $this->moveMenu('/gallery-groups', 'Grup Galeri', 'fas fa-folder', $manajemenKonten->id, 4);
        $this->moveMenu('/documents', 'Pusat Unduhan', 'fas fa-file-download', $manajemenKonten->id, 5);
        $this->moveMenu('/events', 'Agenda & Event', 'fas fa-calendar-alt', $manajemenKonten->id, 6);

        // --- Komunikasi ---
        $this->moveMenu('/contacts', 'Inbox Pesan', 'fas fa-envelope', $komunikasi->id, 1);
        $this->moveMenu('/comments', 'Moderasi Komentar', 'fas fa-comment-dots', $komunikasi->id, 2);
        $this->moveMenu('/announcements', 'Pengumuman', 'fas fa-bullhorn', $komunikasi->id, 3);

        // --- User & Hak Akses ---
        $this->moveMenu('/users', 'Manajemen User', 'fas fa-user-friends', $userAkses->id, 1);
        $this->moveMenu('/roles', 'Role & Hak Akses', 'fas fa-user-shield', $userAkses->id, 2);
        $this->moveMenu('/permissions', 'Daftar Izin', 'fas fa-key', $userAkses->id, 3);
        $this->moveMenu('/permission-groups', 'Grup Izin', 'fas fa-layer-group', $userAkses->id, 4);

        // --- Pengaturan Sistem ---
        $this->moveMenu('/site-settings', 'Identitas Situs', 'fas fa-id-card', $pengaturanSistem->id, 1);
        $this->moveMenu('/dashboard-settings', 'Konfigurasi Dashboard', 'fas fa-tachometer-alt', $pengaturanSistem->id, 2);
        $this->moveMenu('/menus', 'Manajemen Menu', 'fas fa-list', $pengaturanSistem->id, 3);
        $this->moveMenu('/backups', 'Backup Database', 'fas fa-database', $pengaturanSistem->id, 4);
        $this->moveMenu('/logs', 'Audit Logs', 'fas fa-history', $pengaturanSistem->id, 5);

        // Cleanup: Hapus menu lama yang mungkin duplikat atau tidak diperlukan
        Menu::where('title', 'User & Hak Akses')->where('url', '#')->delete();
        Menu::where('title', 'Komunikasi')->where('url', '#')->delete();
    }

    private function moveMenu($url, $title, $icon, $parentId, $order)
    {
        Menu::where('url', $url)->update([
            'title' => $title,
            'icon' => $icon,
            'parent_id' => $parentId,
            'order' => $order,
            'location' => 'admin'
        ]);
    }
}
