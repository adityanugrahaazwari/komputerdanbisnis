<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\StudyProgram;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get Study Programs
        $ap = StudyProgram::where('name', 'Akuntansi Perpajakan')->first();
        $trkj = StudyProgram::where('name', 'Teknik Rekayasa Komputer dan Jaringan')->first();
        $ak = StudyProgram::where('name', 'Akuntansi')->first();
        $ti = StudyProgram::where('name', 'Teknologi Informasi')->first();

        // 2. Sample Lecturers Data
        $lecturers = [
            // Teknologi Informasi (D3)
            [
                'name' => 'Ahmad Fauzi, S.Kom., M.T.',
                'nidn' => '0011223344',
                'position' => 'Ketua Jurusan',
                'expertise' => 'Web Development, Software Engineering',
                'email' => 'ahmad.fauzi@politala.ac.id',
                'study_program_id' => $ti ? $ti->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample1',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample1',
            ],
            [
                'name' => 'Siti Aminah, S.T., M.Kom.',
                'nidn' => '0011223345',
                'position' => 'Sekretaris Jurusan',
                'expertise' => 'Database Systems, Data Mining',
                'email' => 'siti.aminah@politala.ac.id',
                'study_program_id' => $ti ? $ti->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample2',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample2',
            ],
            [
                'name' => 'Budi Santoso, S.Kom., M.Cs.',
                'nidn' => '0011223346',
                'position' => 'Dosen Tetap',
                'expertise' => 'Artificial Intelligence, Machine Learning',
                'email' => 'budi.santoso@politala.ac.id',
                'study_program_id' => $ti ? $ti->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample3',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample3',
            ],
            [
                'name' => 'Dewi Lestari, S.Pd., M.Kom.',
                'nidn' => '0011223347',
                'position' => 'Dosen Tetap',
                'expertise' => 'Multimedia, UI/UX Design',
                'email' => 'dewi.lestari@politala.ac.id',
                'study_program_id' => $ti ? $ti->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample4',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample4',
            ],

            // Teknik Rekayasa Komputer dan Jaringan (D4)
            [
                'name' => 'Ir. H. Muhammad Rizky, M.T.',
                'nidn' => '0022334455',
                'position' => 'Koordinator Program Studi',
                'expertise' => 'Network Security, Cloud Computing',
                'email' => 'm.rizky@politala.ac.id',
                'study_program_id' => $trkj ? $trkj->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample5',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample5',
            ],
            [
                'name' => 'Eko Prasetyo, S.T., M.Eng.',
                'nidn' => '0022334456',
                'position' => 'Dosen Tetap',
                'expertise' => 'Internet of Things (IoT), Embedded Systems',
                'email' => 'eko.prasetyo@politala.ac.id',
                'study_program_id' => $trkj ? $trkj->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample6',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample6',
            ],
            [
                'name' => 'Rina Wijaya, S.T., M.T.',
                'nidn' => '0022334457',
                'position' => 'Dosen Tetap',
                'expertise' => 'Cisco Networking, Cyber Security',
                'email' => 'rina.wijaya@politala.ac.id',
                'study_program_id' => $trkj ? $trkj->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample7',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample7',
            ],
            [
                'name' => 'Fajar Ramadhan, S.Tr.T., M.T.',
                'nidn' => '0022334458',
                'position' => 'Dosen Tetap',
                'expertise' => 'Wireless Communication, Mobile Network',
                'email' => 'fajar.ramadhan@politala.ac.id',
                'study_program_id' => $trkj ? $trkj->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample8',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample8',
            ],

            // Akuntansi Perpajakan (D4)
            [
                'name' => 'Dr. Hj. Ratna Sari, S.E., M.Ak., Ak.',
                'nidn' => '0033445566',
                'position' => 'Koordinator Program Studi',
                'expertise' => 'Taxation Law, Auditing',
                'email' => 'ratna.sari@politala.ac.id',
                'study_program_id' => $ap ? $ap->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample9',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample9',
            ],
            [
                'name' => 'Hadi Kusuma, S.E., M.Si.',
                'nidn' => '0033445567',
                'position' => 'Dosen Tetap',
                'expertise' => 'Financial Accounting, Corporate Tax',
                'email' => 'hadi.kusuma@politala.ac.id',
                'study_program_id' => $ap ? $ap->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample10',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample10',
            ],
            [
                'name' => 'Maya Indah, S.E., M.Ak.',
                'nidn' => '0033445568',
                'position' => 'Dosen Tetap',
                'expertise' => 'Management Accounting, Public Sector Accounting',
                'email' => 'maya.indah@politala.ac.id',
                'study_program_id' => $ap ? $ap->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample11',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample11',
            ],

            // Akuntansi (D3)
            [
                'name' => 'Indra Wijaya, S.E., M.Si., Ak.',
                'nidn' => '0044556677',
                'position' => 'Koordinator Program Studi',
                'expertise' => 'Cost Accounting, Financial Management',
                'email' => 'indra.wijaya@politala.ac.id',
                'study_program_id' => $ak ? $ak->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample12',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample12',
            ],
            [
                'name' => 'Novi Arianti, S.E., M.M.',
                'nidn' => '0044556678',
                'position' => 'Dosen Tetap',
                'expertise' => 'Business Economics, Entrepreneurship',
                'email' => 'novi.arianti@politala.ac.id',
                'study_program_id' => $ak ? $ak->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample13',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample13',
            ],
            [
                'name' => 'Taufik Hidayat, S.E., M.Ak.',
                'nidn' => '0044556679',
                'position' => 'Dosen Tetap',
                'expertise' => 'Computerized Accounting, Accounting Information Systems',
                'email' => 'taufik.hidayat@politala.ac.id',
                'study_program_id' => $ak ? $ak->id : null,
                'google_scholar_url' => 'https://scholar.google.com/citations?user=sample14',
                'sinta_url' => 'https://sinta.kemdikbud.go.id/authors/detail?id=sample14',
            ],
        ];

        // Clear existing lecturers to replace with new data
        Schema::disableForeignKeyConstraints();
        Lecturer::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($lecturers as $lecturer) {
            Lecturer::create([
                'name' => $lecturer['name'],
                'slug' => Str::slug($lecturer['name']),
                'nidn' => $lecturer['nidn'],
                'position' => $lecturer['position'],
                'expertise' => $lecturer['expertise'],
                'email' => $lecturer['email'],
                'google_scholar_url' => $lecturer['google_scholar_url'] ?? null,
                'sinta_url' => $lecturer['sinta_url'] ?? null,
                'study_program_id' => $lecturer['study_program_id'],
                'is_active' => true,
            ]);
        }

        // 3. Create Permissions (Already exists usually, but for completeness)
        $permissions = [
            ['name' => 'View Lecturers', 'slug' => 'lecturers_view', 'group' => 'Lecturer'],
            ['name' => 'Create Lecturers', 'slug' => 'lecturers_create', 'group' => 'Lecturer'],
            ['name' => 'Edit Lecturers', 'slug' => 'lecturers_edit', 'group' => 'Lecturer'],
            ['name' => 'Delete Lecturers', 'slug' => 'lecturers_delete', 'group' => 'Lecturer'],
        ];

        foreach ($permissions as $perm) {
            $group = PermissionGroup::firstOrCreate(
                ['name' => $perm['group']],
                ['slug' => Str::slug($perm['group'])]
            );

            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'permission_group_id' => $group->id
                ]
            );
        }

        // 4. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(Permission::whereIn('slug', array_column($permissions, 'slug'))->pluck('id'));
        }

        // 5. Create Menu under "Manajemen Konten"
        $parent = Menu::where('title', 'Manajemen Konten')->first();
        Menu::updateOrCreate(
            ['url' => '/lecturers'],
            [
                'title' => 'Dosen & Staf',
                'icon' => 'fas fa-users',
                'parent_id' => $parent ? $parent->id : null,
                'permission_slug' => 'lecturers_view',
                'order' => 5
            ]
        );
    }
}
