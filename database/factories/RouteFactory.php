<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Route;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'city' => $this->faker->city(),
            'distance' => $this->faker->randomFloat(0, 0, 9999999999.),
            'time' => $this->faker->time(),
            'status' => $this->faker->randomElement(["pending","started","completed"]),
        ];
    }
}
