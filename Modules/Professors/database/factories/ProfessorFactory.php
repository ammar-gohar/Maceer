<?php

namespace Modules\Professors\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Professors\Models\Professor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

