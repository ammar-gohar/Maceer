<?php

namespace Modules\Reports\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Reports\Models\ReportRequest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

