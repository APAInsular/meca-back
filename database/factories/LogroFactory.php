<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Logro;

class LogroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Logro::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->word(),
            'descripcion' => $this->faker->text(),
            'estado' => $this->faker->randomElement(["pendiente","en_curso","completado"]),
            'tiempo' => $this->faker->dateTime(),
        ];
    }
}
