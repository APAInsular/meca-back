<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Obra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ObraController
 */
final class ObraControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $obras = Obra::factory()->count(3)->create();

        $response = $this->get(route('obras.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ObraController::class,
            'store',
            \App\Http\Requests\Api\ObraControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $titulo = $this->faker->word();
        $tipo = $this->faker->randomElement(/** enum_attributes **/);
        $fecha_creacion = Carbon::parse($this->faker->date());
        $imagen_principal = $this->faker->word();
        $latitud = $this->faker->randomFloat(/** decimal_attributes **/);
        $longitud = $this->faker->randomFloat(/** decimal_attributes **/);
        $significado = $this->faker->text();

        $response = $this->post(route('obras.store'), [
            'titulo' => $titulo,
            'tipo' => $tipo,
            'fecha_creacion' => $fecha_creacion,
            'imagen_principal' => $imagen_principal,
            'latitud' => $latitud,
            'longitud' => $longitud,
            'significado' => $significado,
        ]);

        $obras = Obra::query()
            ->where('titulo', $titulo)
            ->where('tipo', $tipo)
            ->where('fecha_creacion', $fecha_creacion)
            ->where('imagen_principal', $imagen_principal)
            ->where('latitud', $latitud)
            ->where('longitud', $longitud)
            ->where('significado', $significado)
            ->get();
        $this->assertCount(1, $obras);
        $obra = $obras->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $obra = Obra::factory()->create();

        $response = $this->get(route('obras.show', $obra));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $obra = Obra::factory()->create();

        $response = $this->put(route('obras.update', $obra));

        $obra->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $obra = Obra::factory()->create();

        $response = $this->delete(route('obras.destroy', $obra));

        $response->assertNoContent();

        $this->assertModelMissing($obra);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('obras.error'));

        $response->assertNoContent(400);
    }
}
