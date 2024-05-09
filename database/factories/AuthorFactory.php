<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'first_surname' => $this->faker->lastName(),
            'second_surname' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->date(),
            'date_of_death' => $this->faker->optional()->date(),
            'location' => $this->faker->city(),
            'country' => $this->faker->country(),
            'description' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(),
            'video' => $this->faker->optional()->url(),
        ];
    }
}
