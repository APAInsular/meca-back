<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Monument;
use App\Models\QR;
use App\Models\Style;

class MonumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Monument::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'type' => $this->faker->randomElement(["Sculpture","Mural","Painting"]),
            'creation_date' => $this->faker->date(),
            'main_image' => $this->faker->word(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'meaning' => $this->faker->text(),
            'style_id' => Style::factory(),
            'q_r_id' => QR::factory(),
            'address_id' => Address::factory(),
        ];
    }
}
