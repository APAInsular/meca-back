<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Patrocinador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\PatrocinadorController
 */
final class PatrocinadorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $patrocinadors = Patrocinador::factory()->count(3)->create();

        $response = $this->get(route('patrocinadors.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\PatrocinadorController::class,
            'store',
            \App\Http\Requests\Api\PatrocinadorControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $nombre = $this->faker->word();
        $codigo_patrocinador = $this->faker->word();
        $punto_de_interés = $this->faker->word();

        $response = $this->post(route('patrocinadors.store'), [
            'nombre' => $nombre,
            'codigo_patrocinador' => $codigo_patrocinador,
            'punto_de_interés' => $punto_de_interés,
        ]);

        $patrocinadors = Patrocinador::query()
            ->where('nombre', $nombre)
            ->where('codigo_patrocinador', $codigo_patrocinador)
            ->where('punto_de_interés', $punto_de_interés)
            ->get();
        $this->assertCount(1, $patrocinadors);
        $patrocinador = $patrocinadors->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $patrocinador = Patrocinador::factory()->create();

        $response = $this->get(route('patrocinadors.show', $patrocinador));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $patrocinador = Patrocinador::factory()->create();

        $response = $this->put(route('patrocinadors.update', $patrocinador));

        $patrocinador->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $patrocinador = Patrocinador::factory()->create();

        $response = $this->delete(route('patrocinadors.destroy', $patrocinador));

        $response->assertNoContent();

        $this->assertModelMissing($patrocinador);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('patrocinadors.error'));

        $response->assertNoContent(400);
    }
}
