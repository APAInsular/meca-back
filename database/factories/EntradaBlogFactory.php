<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EntradaBlog;

class EntradaBlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EntradaBlog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'título' => $this->faker->word(),
            'contenido' => $this->faker->text(),
            'descripción' => $this->faker->text(),
            'imagen_principal' => $this->faker->word(),
        ];
    }
}
