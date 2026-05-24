<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

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
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
