<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'second_last_name' => $this->faker->lastName,
            'nickname' => $this->faker->userName,
            'profile_picture' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Puedes usar bcrypt('password') también
            'nationality' => $this->faker->country,
            'date_of_birth' => $this->faker->date,
            'location' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'points' => $this->faker->numberBetween(0, 150000),
        ];
    }
}
