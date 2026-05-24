<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\StudyProgram;
use Illuminate\Support\Str;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        $mi = StudyProgram::where('code', 'MI')->first();
        $trpl = StudyProgram::where('code', 'TRPL')->first();
        $ak = StudyProgram::where('code', 'AK')->first();

        $lecturers = [
            // MI
            [
                'name' => 'Dr. Ahmad Fauzi, M.Kom.',
                'nip' => '198501012015011001',
                'nidn' => '0001018501',
                'position' => 'Lektor Kepala',
                'expertise' => 'Artificial Intelligence & Machine Learning',
                'email' => 'ahmad.fauzi@politala.ac.id',
                'study_program_id' => $mi?->id,
                'google_scholar_url' => 'https://scholar.google.com/',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/',
                'order' => 1,
            ],
            [
                'name' => 'Siti Aminah, S.Kom., M.T.',
                'nip' => '199002022018022002',
                'nidn' => '0002029002',
                'position' => 'Asisten Ahli',
                'expertise' => 'Web Development & UI/UX Design',
                'email' => 'siti.aminah@politala.ac.id',
                'study_program_id' => $mi?->id,
                'google_scholar_url' => 'https://scholar.google.com/',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/',
                'order' => 2,
            ],
            // TRPL
            [
                'name' => 'Budi Santoso, M.T.',
                'nip' => '198203032012031003',
                'nidn' => '0003038203',
                'position' => 'Lektor',
                'expertise' => 'Software Engineering & Cloud Computing',
                'email' => 'budi.santoso@politala.ac.id',
                'study_program_id' => $trpl?->id,
                'google_scholar_url' => 'https://scholar.google.com/',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/',
                'order' => 1,
            ],
            [
                'name' => 'Lestari Putri, M.Cs.',
                'nip' => '198804042016042004',
                'nidn' => '0004048804',
                'position' => 'Asisten Ahli',
                'expertise' => 'Mobile Application Development',
                'email' => 'lestari.putri@politala.ac.id',
                'study_program_id' => $trpl?->id,
                'google_scholar_url' => 'https://scholar.google.com/',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/',
                'order' => 2,
            ],
            // AK
            [
                'name' => 'Hendra Wijaya, S.E., M.Ak.',
                'nip' => '198005052010051005',
                'nidn' => '0005058005',
                'position' => 'Lektor',
                'expertise' => 'Accounting Information Systems',
                'email' => 'hendra.wijaya@politala.ac.id',
                'study_program_id' => $ak?->id,
                'google_scholar_url' => 'https://scholar.google.com/',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/',
                'order' => 1,
            ],
            [
                'name' => 'Dewi Sartika, M.Si.',
                'nip' => '199206062020062006',
                'nidn' => '0006069206',
                'position' => 'Tenaga Pengajar',
                'expertise' => 'Financial Auditing & Taxation',
                'email' => 'dewi.sartika@politala.ac.id',
                'study_program_id' => $ak?->id,
                'google_scholar_url' => 'https://scholar.google.com/',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/',
                'order' => 2,
            ],
        ];

        foreach ($lecturers as $lecturer) {
            Lecturer::updateOrCreate(
                ['nip' => $lecturer['nip']],
                array_merge($lecturer, ['slug' => Str::slug($lecturer['name']), 'is_active' => true])
            );
        }
    }
}
