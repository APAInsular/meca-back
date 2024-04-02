<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Ruta;
use App\Models\Rutum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\RutaController
 */
final class RutaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $ruta = Ruta::factory()->count(3)->create();

        $response = $this->get(route('ruta.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\RutaController::class,
            'store',
            \App\Http\Requests\Api\RutaControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $nombre = $this->faker->word();
        $ciudad = $this->faker->word();
        $distancia = $this->faker->randomFloat(/** float_attributes **/);
        $tiempo = $this->faker->time();
        $estado = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('ruta.store'), [
            'nombre' => $nombre,
            'ciudad' => $ciudad,
            'distancia' => $distancia,
            'tiempo' => $tiempo,
            'estado' => $estado,
        ]);

        $ruta = Ruta::query()
            ->where('nombre', $nombre)
            ->where('ciudad', $ciudad)
            ->where('distancia', $distancia)
            ->where('tiempo', $tiempo)
            ->where('estado', $estado)
            ->get();
        $this->assertCount(1, $ruta);
        $rutum = $ruta->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $rutum = Ruta::factory()->create();

        $response = $this->get(route('ruta.show', $rutum));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $rutum = Ruta::factory()->create();

        $response = $this->put(route('ruta.update', $rutum));

        $rutum->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $rutum = Ruta::factory()->create();

        $response = $this->delete(route('ruta.destroy', $rutum));

        $response->assertNoContent();

        $this->assertModelMissing($rutum);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('ruta.error'));

        $response->assertNoContent(400);
    }
}
