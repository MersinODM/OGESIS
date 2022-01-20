<?php

namespace Database\Seeders;

use App\Models\DevPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DevPlan::create([
            'name' => '2021-2022 Eğitim Öğretim Yılı OGP',
            'code' => '21-22',
            'start_date' => Carbon::create(2021, 9, 01),
            'end_date' => Carbon::create(2022, 8, 30),
            'is_open' => true,
            'description' => '2021-2022 Eğitim Öğretm Yılı Okul Gelişim Planı'
        ]);
    }
}
