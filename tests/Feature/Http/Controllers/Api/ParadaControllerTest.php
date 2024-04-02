<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Parada;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ParadaController
 */
final class ParadaControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_responds_with(): void
    {
        $paradas = Parada::factory()->count(3)->create();

        $response = $this->get(route('paradas.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $response = $this->post(route('paradas.store'));

        $response->assertNoContent(201);

        $this->assertDatabaseHas(paradas, [ /* ... */ ]);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $parada = Parada::factory()->create();

        $response = $this->get(route('paradas.show', $parada));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $parada = Parada::factory()->create();

        $response = $this->put(route('paradas.update', $parada));

        $parada->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $parada = Parada::factory()->create();

        $response = $this->delete(route('paradas.destroy', $parada));

        $response->assertNoContent();

        $this->assertModelMissing($parada);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('paradas.error'));

        $response->assertNoContent(400);
    }
}
