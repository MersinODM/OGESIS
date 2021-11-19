<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institutions = Institution::factory()->count(100)->create();
        foreach ($institutions as $institution) {
            $institution->save();
        }
    }
}
