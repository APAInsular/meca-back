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
        return [
            'nickname' => $this->faker->userName,
            'name' => $this->faker->firstName,
            'first_surname' => $this->faker->lastName,
            'second_surname' => $this->faker->lastName,
            'profile_picture' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'confirm_password' => bcrypt('password'),
            'nationality' => $this->faker->country,
            'date_of_birth' => $this->faker->date('Y-m-d', '2003-01-01'),
            'location' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'points' => $this->faker->numberBetween(0, 1000),
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
