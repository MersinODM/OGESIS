<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = Teacher::factory()->count(3000)->create();
        foreach ($teachers as $teacher) {
            $teacher->save();
        }
    }
}
