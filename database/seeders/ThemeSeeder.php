<?php

namespace Database\Seeders;

use App\Imports\ProvinceAndDistrictImport;
use App\Imports\ThemeImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new ThemeImport(), Storage::path('public/temalar.xlsx'));
    }
}
