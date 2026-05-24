<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Webinar: Peluang Karir di Bidang Data Science',
                'description' => 'Webinar interaktif yang menghadirkan pakar data science untuk membahas peluang karir dan skill yang dibutuhkan di tahun 2026.',
                'start_date' => now()->addDays(5)->setTime(10, 0),
                'end_date' => now()->addDays(5)->setTime(12, 0),
                'location' => 'Zoom Meeting',
                'type' => 'webinar',
                'color' => '#10b981', // green-500
            ],
            [
                'title' => 'Pendaftaran Yudisium Gelombang I',
                'description' => 'Batas akhir pendaftaran yudisium bagi mahasiswa yang telah menyelesaikan tugas akhir.',
                'start_date' => now()->addDays(10)->setTime(8, 0),
                'end_date' => now()->addDays(15)->setTime(16, 0),
                'location' => 'Kantor Jurusan',
                'type' => 'academic',
                'color' => '#3b82f6', // blue-500
            ],
            [
                'title' => 'Workshop UI/UX Modern dengan Figma',
                'description' => 'Pelatihan intensif desain antarmuka pengguna untuk mahasiswa tingkat akhir.',
                'start_date' => now()->addDays(20)->setTime(9, 0),
                'end_date' => now()->addDays(20)->setTime(15, 0),
                'location' => 'Lab Komputer 2',
                'type' => 'webinar',
                'color' => '#8b5cf6', // purple-500
            ],
            [
                'title' => 'Kompetisi Programming JKB Cup',
                'description' => 'Lomba coding antar mahasiswa Jurusan Komputer dan Bisnis.',
                'start_date' => now()->addDays(25)->setTime(8, 0),
                'end_date' => now()->addDays(26)->setTime(17, 0),
                'location' => 'Gedung TI',
                'type' => 'competition',
                'color' => '#f59e0b', // amber-500
            ],
            [
                'title' => 'Libur Semester Genap',
                'description' => 'Masa libur perkuliahan setelah ujian akhir semester.',
                'start_date' => now()->addMonth()->startOfMonth(),
                'end_date' => now()->addMonth()->startOfMonth()->addDays(14),
                'location' => '-',
                'type' => 'holiday',
                'color' => '#ef4444', // red-500
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(
                ['slug' => Str::slug($event['title'])],
                array_merge($event, ['is_active' => true])
            );
        }
    }
}
