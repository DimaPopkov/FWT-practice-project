<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'subject_id' => Subject::inRandomOrder()->first()->id ?? Subject::factory(),
            'grade' => $this->faker->numberBetween(1, 5),
        ];
    }
}
