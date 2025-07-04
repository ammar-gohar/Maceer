<?php

namespace Modules\Reports\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Reports\Models\Receipt::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

