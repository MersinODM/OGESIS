<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            ProvinceSeeder::class,
            BranchSeeder::class,
            InstitutionSeeder::class,
            TeacherSeeder::class,
            PartnerSeeder::class,
            ThemeSeeder::class,
            PlanSeeder::class,
        ]);
    }
}
