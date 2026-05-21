<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostSubmission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $operator = User::where('email', 'operator@example.com')->first();

        if (!$admin || !$operator) {
            $this->command->error('Admin or Operator user not found. Please run RbacSeeder first.');
            return;
        }

        // 1. Post by Operator: Pending Review
        $post1 = Post::create([
            'title' => 'Inovasi Teknologi di Era Digital 2026',
            'slug' => Str::slug('Inovasi Teknologi di Era Digital 2026'),
            'content' => 'Teknologi terus berkembang pesat. Di tahun 2026 ini, kecerdasan buatan telah merambah ke berbagai sektor industri, memberikan efisiensi yang belum pernah terbayangkan sebelumnya.',
            'user_id' => $operator->id,
            'status' => 'pending',
        ]);

        PostSubmission::create([
            'post_id' => $post1->id,
            'user_id' => $operator->id,
            'status' => 'draft',
            'notes' => 'Mulai menulis draf awal.',
        ]);

        PostSubmission::create([
            'post_id' => $post1->id,
            'user_id' => $operator->id,
            'status' => 'pending',
            'notes' => 'Sudah selesai, mohon direview oleh admin.',
        ]);

        // 2. Post by Operator: Published by Admin
        $post2 = Post::create([
            'title' => 'Tips Keamanan Siber bagi Pengguna Rumahan',
            'slug' => Str::slug('Tips Keamanan Siber bagi Pengguna Rumahan'),
            'content' => 'Keamanan data pribadi adalah prioritas utama. Berikut adalah beberapa langkah mudah untuk menjaga keamanan jaringan WiFi dan perangkat pintar di rumah Anda dari serangan peretas.',
            'user_id' => $operator->id,
            'status' => 'published',
        ]);

        PostSubmission::create([
            'post_id' => $post2->id,
            'user_id' => $operator->id,
            'status' => 'pending',
            'notes' => 'Artikel edukasi tentang keamanan siber.',
        ]);

        PostSubmission::create([
            'post_id' => $post2->id,
            'user_id' => $admin->id,
            'status' => 'published',
            'notes' => 'Artikel sangat bagus dan relevan. Layak terbit.',
        ]);

        // 3. Post by Operator: Rejected by Admin
        $post3 = Post::create([
            'title' => 'Berita Hoax yang Harus Dihindari',
            'slug' => Str::slug('Berita Hoax yang Harus Dihindari'),
            'content' => 'Jangan mudah percaya dengan informasi yang beredar tanpa sumber yang jelas. Selalu lakukan cek fakta sebelum membagikan informasi ke grup WhatsApp keluarga.',
            'user_id' => $operator->id,
            'status' => 'rejected',
        ]);

        PostSubmission::create([
            'post_id' => $post3->id,
            'user_id' => $operator->id,
            'status' => 'pending',
            'notes' => 'Pengajuan berita cek fakta.',
        ]);

        PostSubmission::create([
            'post_id' => $post3->id,
            'user_id' => $admin->id,
            'status' => 'rejected',
            'notes' => 'Konten terlalu singkat dan kurang referensi kuat. Harap diperbaiki.',
        ]);

        // 4. Post by Admin: Directly Published
        $post4 = Post::create([
            'title' => 'Pengumuman Resmi: Hari Libur Nasional 2026',
            'slug' => Str::slug('Pengumuman Resmi: Hari Libur Nasional 2026'),
            'content' => 'Pemerintah telah menetapkan daftar hari libur nasional dan cuti bersama untuk tahun 2026 melalui surat keputusan bersama tiga menteri.',
            'user_id' => $admin->id,
            'status' => 'published',
        ]);

        PostSubmission::create([
            'post_id' => $post4->id,
            'user_id' => $admin->id,
            'status' => 'published',
            'notes' => 'Pengumuman resmi dari pimpinan.',
        ]);

        // 5. Post by Operator: Still Draft
        $post5 = Post::create([
            'title' => 'Review Laptop Gaming Terbaru 2026',
            'slug' => Str::slug('Review Laptop Gaming Terbaru 2026'),
            'content' => 'Sedang dikerjakan...',
            'user_id' => $operator->id,
            'status' => 'draft',
        ]);

        PostSubmission::create([
            'post_id' => $post5->id,
            'user_id' => $operator->id,
            'status' => 'draft',
            'notes' => 'Masih mencari referensi spesifikasi teknis.',
        ]);

        $this->command->info('PostSeeder completed successfully with sample submission history!');
    }
}
