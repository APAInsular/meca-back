<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Estilo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\EstiloController
 */
final class EstiloControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $estilos = Estilo::factory()->count(3)->create();

        $response = $this->get(route('estilos.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\EstiloController::class,
            'store',
            \App\Http\Requests\Api\EstiloControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $nombre = $this->faker->word();

        $response = $this->post(route('estilos.store'), [
            'nombre' => $nombre,
        ]);

        $estilos = Estilo::query()
            ->where('nombre', $nombre)
            ->get();
        $this->assertCount(1, $estilos);
        $estilo = $estilos->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $estilo = Estilo::factory()->create();

        $response = $this->get(route('estilos.show', $estilo));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $estilo = Estilo::factory()->create();

        $response = $this->put(route('estilos.update', $estilo));

        $estilo->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $estilo = Estilo::factory()->create();

        $response = $this->delete(route('estilos.destroy', $estilo));

        $response->assertNoContent();

        $this->assertModelMissing($estilo);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('estilos.error'));

        $response->assertNoContent(400);
    }
}
