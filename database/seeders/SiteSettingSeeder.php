<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions
        $group = PermissionGroup::where('slug', 'system_settings')->first();
        if (!$group) {
            $group = PermissionGroup::create(['name' => 'System Settings', 'slug' => 'system_settings']);
        }

        $permission = Permission::updateOrCreate(
            ['slug' => 'site_settings_edit'],
            ['name' => 'Edit General Settings', 'permission_group_id' => $group->id]
        );

        // 2. Assign to Admin
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching([$permission->id]);
        }

        // 3. Menu
        $systemMenu = Menu::where('title', 'Pengaturan Sistem')->first();
        Menu::updateOrCreate(
            ['url' => '/site-settings'],
            [
                'title' => 'Identitas Situs',
                'icon' => 'fas fa-id-card',
                'parent_id' => $systemMenu ? $systemMenu->id : null,
                'permission_slug' => 'site_settings_edit',
                'order' => 1,
                'is_active' => true,
                'location' => 'admin'
            ]
        );

        // 4. Default Settings
        SiteSetting::updateOrCreate(['key' => 'site_name'], ['value' => 'JKB POLITALA']);
        SiteSetting::updateOrCreate(['key' => 'site_description'], ['value' => 'Jurusan Komputer dan Bisnis - Politeknik Negeri Tanah Laut. Menghasilkan lulusan yang unggul, profesional, dan berjiwa wirausaha.']);
        SiteSetting::updateOrCreate(['key' => 'site_keywords'], ['value' => 'Politala, JKB, Komputer dan Bisnis, Politeknik Negeri Tanah Laut, Teknik Informatika, Akuntansi, Pelaihari']);
        SiteSetting::updateOrCreate(['key' => 'site_address'], ['value' => 'Jl. Ahmad Yani KM.06, Desa Panggung, Pelaihari, Tanah Laut, Kalimantan Selatan.']);
        SiteSetting::updateOrCreate(['key' => 'site_phone'], ['value' => '(0512) 2021065']);
        SiteSetting::updateOrCreate(['key' => 'site_email'], ['value' => 'jkb@politala.ac.id']);
        SiteSetting::updateOrCreate(['key' => 'contact_title'], ['value' => 'Kontak Kami']);
        SiteSetting::updateOrCreate(['key' => 'contact_description'], ['value' => 'Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami melalui formulir di bawah ini atau melalui kontak resmi kami.']);
        SiteSetting::updateOrCreate(['key' => 'hero_badge'], ['value' => 'POLITEKNIK NEGERI TANAH LAUT']);
        SiteSetting::updateOrCreate(['key' => 'hero_title'], ['value' => 'EXCELLENT INNOVATIVE PROFESSIONAL']);
        SiteSetting::updateOrCreate(['key' => 'hero_subtitle'], ['value' => 'Mencetak tenaga kerja handal di bidang teknologi informasi dan manajemen bisnis yang siap bersaing di kancah nasional dan global.']);
        SiteSetting::updateOrCreate(['key' => 'hero_btn1_text'], ['value' => 'Program Studi']);
        SiteSetting::updateOrCreate(['key' => 'hero_btn1_url'], ['value' => '#prodi']);
        SiteSetting::updateOrCreate(['key' => 'hero_btn2_text'], ['value' => 'Profil Jurusan']);
        SiteSetting::updateOrCreate(['key' => 'hero_btn2_url'], ['value' => '/profil']);
        SiteSetting::updateOrCreate(['key' => 'footer_text'], ['value' => '© ' . date('Y') . ' Jurusan Komputer dan Bisnis - POLITALA']);
    }
}
