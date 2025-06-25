<?php

namespace Modules\Semesters\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Semesters\Models\Semester::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $start = $this->faker->dateTimeBetween('-2 years', 'now');

        return [
            'name' => $this->faker->word(),
            'start_date' => $start,
            'end_date' => $start->modify('+4 months'),
            'is_current' => false,
        ];
    }
}

