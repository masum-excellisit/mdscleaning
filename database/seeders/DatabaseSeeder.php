<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SiteSettingSeeder::class,
            BannerSeeder::class,
            HomepageSectionSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
