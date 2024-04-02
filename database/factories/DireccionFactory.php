<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Direccion;

class DireccionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Direccion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'direccion' => $this->faker->word(),
            'ciudad' => $this->faker->word(),
            'cp' => $this->faker->word(),
            'provincia' => $this->faker->word(),
            'pais' => $this->faker->word(),
            'calle' => $this->faker->word(),
            'piso_bloque_edificio' => $this->faker->word(),
        ];
    }
}
