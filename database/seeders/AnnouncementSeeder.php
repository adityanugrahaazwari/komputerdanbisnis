<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        $announcements = [
            [
                'user_id' => $admin->id,
                'title' => 'Pendaftaran Mahasiswa Baru Jalur Mandiri Telah Dibuka!',
                'message' => 'Segera daftarkan diri Anda di website resmi PMB Politala. Batas akhir pendaftaran hingga 30 Juli 2026.',
                'type' => 'danger',
                'is_active' => true,
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Kuliah Umum Bersama Industri: Masa Depan AI',
                'message' => 'Jangan lewatkan kuliah umum yang akan dilaksanakan pada hari Senin mendatang di Aula Utama.',
                'type' => 'info',
                'is_active' => true,
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Jadwal Pengisian KRS Semester Ganjil 2026/2027',
                'message' => 'Mahasiswa diwajibkan melakukan pengisian KRS online mulai tanggal 1-15 Agustus 2026.',
                'type' => 'warning',
                'is_active' => true,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        Announcement::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($announcements as $ann) {
            Announcement::create($ann);
        }
    }
}
