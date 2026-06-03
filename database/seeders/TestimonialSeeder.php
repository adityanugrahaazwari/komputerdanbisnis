<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Budi Santoso, S.Kom.',
                'role' => 'Alumni 2018 / Senior Developer',
                'company' => 'Gojek Indonesia',
                'quote' => 'Kurikulum di JKB Politala sangat relevan dengan kebutuhan industri saat ini. Saya merasa sangat terbantu dengan materi praktikum yang intensif.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'HR Manager',
                'company' => 'PT Teknologi Jaya',
                'quote' => 'Lulusan JKB Politala memiliki etos kerja yang luar biasa dan kemampuan teknis yang sangat mumpuni. Kami sangat senang bekerja sama dengan jurusan ini.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Andi Wijaya, M.T.',
                'role' => 'Alumni 2019 / CEO',
                'company' => 'Startup Lokal Banjarmasin',
                'quote' => 'Jiwa entrepreneurship saya terbentuk saat kuliah di JKB Politala. Dosen-dosennya sangat mendukung mahasiswanya untuk berinovasi.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Rina Wijaya, S.E.',
                'role' => 'Alumni 2020 / Accountant',
                'company' => 'Bank Mandiri',
                'quote' => 'Fasilitas laboratorium di JKB sangat lengkap dan modern. Hal ini sangat mendukung proses belajar mengajar kami menjadi lebih efektif.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Hendra Kusuma, S.T.',
                'role' => 'Project Manager',
                'company' => 'PT Cloud Indonesia',
                'quote' => 'Kerjasama antara JKB dengan industri sangat erat. Banyak lulusannya yang langsung terserap kerja bahkan sebelum wisuda.',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        Testimonial::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
