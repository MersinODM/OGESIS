<?php

namespace Database\Factories;

use App\Models\Institution;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => $this->faker->numberBetween(100, 209),
            'institution_id' => Institution::select('id')->inRandomOrder()->first()->value('id'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->email(),
        ];
    }
}
