<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Direccion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\DireccionController
 */
final class DireccionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $direccions = Direccion::factory()->count(3)->create();

        $response = $this->get(route('direccions.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\DireccionController::class,
            'store',
            \App\Http\Requests\Api\DireccionControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $direccion = $this->faker->word();
        $ciudad = $this->faker->word();
        $cp = $this->faker->word();
        $provincia = $this->faker->word();
        $pais = $this->faker->word();
        $calle = $this->faker->word();
        $piso_bloque_edificio = $this->faker->word();

        $response = $this->post(route('direccions.store'), [
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'cp' => $cp,
            'provincia' => $provincia,
            'pais' => $pais,
            'calle' => $calle,
            'piso_bloque_edificio' => $piso_bloque_edificio,
        ]);

        $direccions = Direccion::query()
            ->where('direccion', $direccion)
            ->where('ciudad', $ciudad)
            ->where('cp', $cp)
            ->where('provincia', $provincia)
            ->where('pais', $pais)
            ->where('calle', $calle)
            ->where('piso_bloque_edificio', $piso_bloque_edificio)
            ->get();
        $this->assertCount(1, $direccions);
        $direccion = $direccions->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $direccion = Direccion::factory()->create();

        $response = $this->get(route('direccions.show', $direccion));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $direccion = Direccion::factory()->create();

        $response = $this->put(route('direccions.update', $direccion));

        $direccion->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $direccion = Direccion::factory()->create();

        $response = $this->delete(route('direccions.destroy', $direccion));

        $response->assertNoContent();

        $this->assertModelMissing($direccion);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('direccions.error'));

        $response->assertNoContent(400);
    }
}
