<?php

namespace Modules\Halls\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Halls\Models\Hall::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'capacity' => $this->faker->numberBetween(20, 500),
            'type' => $this->faker->randomElement(['theatre', 'lab']),
            'status' => $this->faker->randomElement(['available', 'under_maintenance', 'reserved']),
            'building' => $this->faker->randomElement(['Building A', 'Building B', 'Building C', 'Building D']),
            'floor' => $this->faker->numberBetween(1, 5),
        ];
    }
}

