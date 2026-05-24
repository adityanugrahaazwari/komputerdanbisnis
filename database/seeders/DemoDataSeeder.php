<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Models\Lecturer;
use App\Models\Post;
use App\Models\StudyProgram;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        // 1. Categories
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik'],
            ['name' => 'Kemahasiswaan', 'slug' => 'kemahasiswaan'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman'],
            ['name' => 'Berita Utama', 'slug' => 'berita-utama'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
        $catIds = Category::pluck('id')->toArray();

        // 2. Additional Posts with categories
        $posts = [
            [
                'title' => 'Pendaftaran Mahasiswa Baru Jalur Prestasi 2026',
                'content' => 'Telah dibuka pendaftaran mahasiswa baru jalur prestasi akademik dan non-akademik. Silakan cek dokumen persyaratan di menu unduhan.',
                'category_id' => $catIds[0],
            ],
            [
                'title' => 'Prestasi Mahasiswa di Kontes Robot Nasional',
                'content' => 'Mahasiswa JKB berhasil meraih juara 1 di Kontes Robot Indonesia kategori Robot Pemadam Api.',
                'category_id' => $catIds[1],
            ],
            [
                'title' => 'Kuliah Umum Bersama CEO Startup Unicorn',
                'content' => 'Jangan lewatkan kuliah umum yang akan membahas masa depan ekonomi digital di Aula Politeknik.',
                'category_id' => $catIds[3],
            ],
        ];

        foreach ($posts as $p) {
            Post::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                array_merge($p, [
                    'user_id' => $admin->id,
                    'status' => 'published',
                    'meta_description' => Str::limit($p['content'], 150),
                ])
            );
        }

        // 3. Comments
        $publishedPosts = Post::where('status', 'published')->get();
        foreach ($publishedPosts as $post) {
            Comment::updateOrCreate(
                ['post_id' => $post->id, 'user_email' => 'visitor@example.com'],
                [
                    'user_name' => 'Pengunjung Web',
                    'comment' => 'Informasi yang sangat bermanfaat, terima kasih JKB!',
                    'status' => 'approved',
                ]
            );
        }

        // 4. Gallery Groups & Galleries
        $group1 = GalleryGroup::updateOrCreate(['slug' => 'fasilitas'], ['name' => 'Fasilitas Kampus', 'is_active' => true]);
        $group2 = GalleryGroup::updateOrCreate(['slug' => 'kegiatan-mahasiswa'], ['name' => 'Kegiatan Mahasiswa', 'is_active' => true]);

        Gallery::updateOrCreate(['title' => 'Laboratorium Komputer'], [
            'gallery_group_id' => $group1->id,
            'image' => 'gallery/demo-lab.jpg',
            'order' => 1,
            'is_active' => true
        ]);

        Gallery::updateOrCreate(['title' => 'Wisuda Angkatan XV'], [
            'gallery_group_id' => $group2->id,
            'image' => 'gallery/demo-wisuda.jpg',
            'order' => 1,
            'is_active' => true
        ]);

        // 5. Documents
        Document::updateOrCreate(['title' => 'Panduan KRS Online 2026'], [
            'file_path' => 'documents/demo-krs.pdf',
            'category' => 'Panduan',
            'description' => 'Tata cara pengisian Kartu Rencana Studi bagi mahasiswa aktif.',
            'is_active' => true
        ]);

        Document::updateOrCreate(['title' => 'Kalender Akademik Ganjil 2026/2027'], [
            'file_path' => 'documents/demo-kalender.pdf',
            'category' => 'Akademik',
            'description' => 'Jadwal perkuliahan, UTS, dan UAS semester ganjil.',
            'is_active' => true
        ]);

        // 6. Contacts (Inbox)
        Contact::updateOrCreate(['email' => 'calon.mhs@example.com', 'subject' => 'Tanya Pendaftaran'], [
            'name' => 'Budi Santoso',
            'message' => 'Halo Admin, apakah pendaftaran jalur mandiri masih dibuka untuk program studi Manajemen Informatika?',
            'is_read' => false
        ]);

        // 7. Services
        Service::updateOrCreate(['title' => 'Sistem Informasi Akademik (SIAKAD)'], [
            'description' => 'Layanan pengelolaan data akademik mahasiswa, nilai, dan KRS.',
            'icon' => 'fas fa-graduation-cap',
            'url' => 'https://siakad.politala.ac.id',
            'order' => 1,
            'is_active' => true
        ]);

        Service::updateOrCreate(['title' => 'E-Learning JKB'], [
            'description' => 'Platform pembelajaran daring untuk seluruh mata kuliah di JKB.',
            'icon' => 'fas fa-laptop-code',
            'url' => 'https://elearning.politala.ac.id',
            'order' => 2,
            'is_active' => true
        ]);

        // 8. Events
        Event::updateOrCreate(['title' => 'Workshop UI/UX Design'], [
            'slug' => Str::slug('Workshop UI/UX Design'),
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'type' => 'academic',
            'color' => '#ef4444',
            'location' => 'Lab Multimedia',
            'description' => 'Belajar desain antarmuka modern menggunakan Figma.',
            'is_active' => true
        ]);

        $this->command->info('DemoDataSeeder successfully populated the database with initial samples!');
    }
}
