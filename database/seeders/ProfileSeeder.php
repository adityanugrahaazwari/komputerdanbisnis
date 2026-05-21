<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Content
        $sections = [
            [
                'key' => 'vision',
                'title' => 'Visi Jurusan',
                'content' => 'Menjadi Jurusan unggulan dalam menghasilkan sumber daya manusia yang kompeten, inovatif, dan berjiwa wirausaha di bidang teknologi informasi dan bisnis pada tingkat nasional maupun internasional.'
            ],
            [
                'key' => 'mission',
                'title' => 'Misi Jurusan',
                'content' => "1. Menyelenggarakan pendidikan vokasi yang berkualitas di bidang teknologi informasi dan bisnis.\n2. Melaksanakan penelitian terapan yang inovatif dan solutif bagi kebutuhan industri dan masyarakat.\n3. Melaksanakan pengabdian kepada masyarakat dalam rangka penyebarluasan ilmu pengetahuan dan teknologi.\n4. Menjalin kerjasama yang produktif dengan dunia usaha dan dunia industri (DUDI)."
            ],
            [
                'key' => 'history',
                'title' => 'Sejarah Jurusan',
                'content' => 'Jurusan Komputer dan Bisnis merupakan salah satu jurusan di Politeknik Negeri Tanah Laut yang didirikan untuk menjawab kebutuhan tenaga kerja terampil di era transformasi digital. Berfokus pada sinergi antara keahlian teknis komputer dan manajemen bisnis.'
            ],
            [
                'key' => 'structure',
                'title' => 'Struktur Organisasi Jurusan',
                'content' => 'Struktur organisasi Jurusan Komputer dan Bisnis dipimpin oleh Ketua Jurusan dan Sekretaris Jurusan, membawahi Koordinator Program Studi dan Kepala Laboratorium di lingkungan Politeknik Negeri Tanah Laut.'
            ],
        ];

        foreach ($sections as $section) {
            Profile::updateOrCreate(['key' => $section['key']], $section);
        }

        // 2. Create Permissions
        $permissions = [
            ['name' => 'View Profiles', 'slug' => 'profiles_view', 'group' => 'Web Profile'],
            ['name' => 'Edit Profiles', 'slug' => 'profiles_edit', 'group' => 'Web Profile'],
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

        // 3. Assign to Roles
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(Permission::whereIn('slug', ['profiles_view', 'profiles_edit'])->pluck('id'));
        }

        // 4. Create Menu under "Profil Lembaga"
        $parent = Menu::where('title', 'Profil Lembaga')->first();
        Menu::updateOrCreate(
            ['url' => '/profiles'],
            [
                'title' => 'Informasi Umum',
                'icon' => 'fas fa-info-circle',
                'parent_id' => $parent ? $parent->id : null,
                'permission_slug' => 'profiles_view',
                'order' => 1
            ]
        );
    }
}
