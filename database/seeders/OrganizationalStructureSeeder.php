<?php

namespace Database\Seeders;

use App\Models\OrganizationalStructure;
use Illuminate\Database\Seeder;

class OrganizationalStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplicates
        OrganizationalStructure::truncate();

        // 1. Level 1: 1 Ketua Jurusan
        $kajur = OrganizationalStructure::create([
            'name' => 'Dr. H. Mufrida Zein, S.Ag., M.Pd.',
            'position' => 'Ketua Jurusan Komputer dan Bisnis',
            'order' => 1,
            'parent_id' => null,
        ]);

        // 2. Level 2: 1 Sekretaris Jurusan (Bawahan Ketua Jurusan)
        $sekjur = OrganizationalStructure::create([
            'name' => 'H. Jubaidi, S.Ag., M.Pd.',
            'position' => 'Sekretaris Jurusan',
            'order' => 1,
            'parent_id' => $kajur->id,
        ]);

        // 3. Level 2: 1 Kepala Laboratorium (Bawahan Ketua Jurusan)
        OrganizationalStructure::create([
            'name' => 'Hendra Wijaya, S.Kom., M.T.',
            'position' => 'Kepala Laboratorium',
            'order' => 2,
            'parent_id' => $kajur->id,
        ]);

        // 4. Level 3: 1 Staf Jurusan (Bawahan Sekretaris Jurusan)
        OrganizationalStructure::create([
            'name' => 'Siti Aminah, S.Pd.',
            'position' => 'Staf Jurusan',
            'order' => 1,
            'parent_id' => $sekjur->id,
        ]);
    }
}
