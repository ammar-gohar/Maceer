<?php

namespace Modules\Enrollments\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Grades\Models\Grade;

class EnrollmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Enrollments\Models\Enrollment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $midterm_exam = $this->faker->numberBetween(0, 20);
        $final_exam = $this->faker->numberBetween(0, 50);
        $total_mark = $midterm_exam + $final_exam;

        $grades = Grade::all();

        return [
            'midterm_exam' => $midterm_exam,
            'final_exam' => $final_exam,
            'total_mark' => $total_mark,
            'total_mark_percentage' => $total_mark / 100 * 100,
            'quality_points' => $this->faker->randomFloat(2, 0, 4.0),
            'final_gpa' => $this->faker->randomFloat(2, 0, 4.0),
            'grade_id' => $grades->random(),
            'work_mark' => $this->faker->numberBetween(0, 30),
            'shown_columns' => implode('-', [
                'midterm_exam',
                'final_exam',
                'total_mark',
                'total_mark_percentage',
                'quality_points',
                'final_gpa',
                'grade_id',
            ]),
            'approved_at' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
        ];
    }
}

