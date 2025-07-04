<?php

namespace Modules\Students\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Levels\Models\Level;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Students\Models\Student::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $levels = Level::all()->toArray();
        $universityCredits = fake()->numberBetween(0, 30);
        $facultyCredits = fake()->numberBetween(0, 30);
        $programCredits = fake()->numberBetween(0, 30);
        $coreCredits = fake()->numberBetween(0, 30);
        $totalCredits = $universityCredits + $facultyCredits + $programCredits + $coreCredits;
        $maximumCreditsToEnroll = fake()->numberBetween(12, 18);
        return [
            // 'level_id' => $levels[array_rand($levels)]['id'],
            // 'gpa' => fake()->randomFloat(2, 0, 4),
            // 'unversity_elected_earned_credits' => $universityCredits,
            // 'faculty_elected_earned_credits' => $facultyCredits,
            // 'program_elected_earned_credits' => $programCredits,
            // 'core_earned_credits' => $coreCredits,
            // 'total_earned_credits' => $totalCredits,
            // 'maximum_credits_to_enroll' => $maximumCreditsToEnroll,
        ];
    }
}

