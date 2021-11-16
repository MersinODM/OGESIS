<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $hkn = new User([
                "full_name" => "Hakan GÜLEN",
                "email" => "hgulen33@gmail.com",
                "password" => Hash::make("Hakan.33")
            ]);
            $hkn->save();
            $hkn->assignRole("admin");
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}