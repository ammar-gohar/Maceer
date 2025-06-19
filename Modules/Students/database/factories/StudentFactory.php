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
        $id = Level::orderBy('created_at', 'asc')->first();
        return [
            'level_id' => $id,
        ];
    }
}

