<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Direccion;
use App\Models\Estilo;
use App\Models\Obra;
use App\Models\QR;

class ObraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Obra::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->word(),
            'tipo' => $this->faker->randomElement(["Escultura","Mural","Pintura"]),
            'fecha_creacion' => $this->faker->date(),
            'imagen_principal' => $this->faker->word(),
            'latitud' => $this->faker->randomFloat(0, 0, 9999999999.),
            'longitud' => $this->faker->randomFloat(0, 0, 9999999999.),
            'significado' => $this->faker->text(),
            'estilo_id' => Estilo::factory(),
            'q_r_id' => QR::factory(),
            'direccion_id' => Direccion::factory(),
        ];
    }
}
