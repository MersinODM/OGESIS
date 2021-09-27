<?php

namespace Database\Seeders;

use App\Imports\ProvinceAndDistrictImport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Excel::import(new ProvinceAndDistrictImport, Storage::path('public/il_ilceler.xlsx'));
    }
}