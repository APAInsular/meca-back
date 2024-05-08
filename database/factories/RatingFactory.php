<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5), // Generar una calificación aleatoria entre 1 y 5
            'rateable_type' => 'App\Models\Monument', // Tipo de modelo al que se está asignando la calificación
            'rateable_id' => $this->faker->numberBetween(1, 50), // ID aleatorio de un monumento (ajusta el rango según tus necesidades)
        ];
    }
}
