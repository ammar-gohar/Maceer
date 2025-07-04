<?php

namespace Modules\Semesters\Database\Factories;

use Carbon\Carbon;
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
            'name' => $this->faker->randomElement(['First ' . Carbon::parse($start)->format('Y'), 'Second ' . Carbon::parse($start)->format('Y')]),
            'start_date' => $start,
            'end_date' => $start->modify('+4 months'),
            'requests_start_date' => $start->modify('+2 weeks'),
            'enrollments_start_date' => $start->modify('+3 weeks'),
            'enrollments_end_date' => $start->modify('+5 weeks'),
            'is_current' => false,
        ];
    }
}

