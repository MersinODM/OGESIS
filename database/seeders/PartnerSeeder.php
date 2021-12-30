<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::create(['name' =>'Öğrenciler']);
        Partner::create(['name' =>'Öğretmenler']);
        Partner::create(['name' =>'Veliler']);
        Partner::create(['name' =>'Belediye']);
        Partner::create(['name' =>'Sivil Toplum Kuruluşları']);
    }
}
