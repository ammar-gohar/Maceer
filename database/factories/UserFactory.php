<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public $i = 0;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['m', 'f']);
        $this->i++;
        return [
            'first_name' => $gender == 'm' ? fake()->firstNameMale() : fake()->firstNameFemale(),
            'middle_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'national_id' => fake()->unique()->numberBetween(12000000000000, 12999999999999),
            'username' => 'student' . $this->i,
            'email' => fake()->unique()->email(),
            'phone' => '01' . fake()->unique()->numberBetween(100000000, 999999999),
            'gender' => $gender,
            'password' => Hash::make('password'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
