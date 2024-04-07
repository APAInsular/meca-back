<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Evento;

class EventoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evento::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->word(),
            'descripcion' => $this->faker->text(),
            'max_inscritos' => $this->faker->numberBetween(-10000, 10000),
            'tipo_usuario' => $this->faker->randomElement(["creador","participante"]),
        ];
    }
}
