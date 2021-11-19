<?php

namespace Database\Seeders;

use App\Imports\BranchImport;
use App\Imports\ProvinceAndDistrictImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new BranchImport(), Storage::path('public/branslar.xlsx'));
    }
}
