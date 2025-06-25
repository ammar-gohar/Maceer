<?php

namespace Modules\Courses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Courses\Models\Schedule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        return [
            'start_period' => $this->faker->randomElement(['1', '3', '5', '7', '9']),
            'day' => $this->faker->randomElement(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday']),
            'max_enrollments_number' => $this->faker->numberBetween(20, 80),
            'students_enrollments_number' => $this->faker->numberBetween(0, 80),
        ];
    }
}

