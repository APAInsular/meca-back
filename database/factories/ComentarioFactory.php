<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Comentario;
use App\Models\User;

class ComentarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comentario::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'contenido' => $this->faker->text(),
            'imagen_principal' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
