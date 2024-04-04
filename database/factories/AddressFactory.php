<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->word(),
            'city' => $this->faker->city(),
            'zip_code' => $this->faker->word(),
            'province' => $this->faker->word(),
            'country' => $this->faker->country(),
            'street' => $this->faker->streetName(),
            'floor_block_building' => $this->faker->word(),
        ];
    }
}
