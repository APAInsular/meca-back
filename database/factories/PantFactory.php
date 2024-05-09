<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pant>
 */
class PantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sex_id' => \App\Models\Sex::factory(),
            'category' => $this->faker->word,
            'subcategory' => $this->faker->word,
            'url' => $this->faker->imageUrl(),
            'url_selection' => $this->faker->imageUrl(),
        ];
    }
}
