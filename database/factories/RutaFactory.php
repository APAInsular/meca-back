<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ruta;

class RutaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ruta::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'ciudad' => $this->faker->word(),
            'distancia' => $this->faker->randomFloat(0, 0, 9999999999.),
            'tiempo' => $this->faker->time(),
            'estado' => $this->faker->randomElement(["pendiente","comenzada","completada"]),
        ];
    }
}
