<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RbacSeeder::class,
            PermissionGroupRbacSeeder::class,
            PostRbacSeeder::class,
            PostSeeder::class,
            ProfileSeeder::class,
            OrganizationalStructureRbacSeeder::class,
            OrganizationalStructureSeeder::class,
            StudyProgramSeeder::class,
            SocialMediaSeeder::class,
            AccountMenuSeeder::class,
            AnnouncementRbacSeeder::class,
            AnnouncementSeeder::class,
            DashboardSettingSeeder::class,
            TestimonialRbacSeeder::class,
            TestimonialSeeder::class,
            MediaManagerRbacSeeder::class,
            EventRbacSeeder::class,
            EventSeeder::class,
            LecturerRbacSeeder::class,
            LecturerSeeder::class,
            ServiceRbacSeeder::class,
            SiteSettingSeeder::class,
            FrontendMenusSeeder::class,
            DemoDataSeeder::class,
            RearrangeAdminMenuSeeder::class,
        ]);
    }
}
