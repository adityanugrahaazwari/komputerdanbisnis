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
            StudyProgramSeeder::class,
            SocialMediaSeeder::class,
            AccountMenuSeeder::class,
            AnnouncementRbacSeeder::class,
            DashboardSettingSeeder::class,
            TestimonialRbacSeeder::class,
            MediaManagerRbacSeeder::class,
        ]);
    }
}
