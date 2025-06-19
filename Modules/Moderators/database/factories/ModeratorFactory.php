<?php

namespace Modules\Moderators\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModeratorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Moderators\Models\Moderator::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

