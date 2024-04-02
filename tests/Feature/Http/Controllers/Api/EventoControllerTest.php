<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Evento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\EventoController
 */
final class EventoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $eventos = Evento::factory()->count(3)->create();

        $response = $this->get(route('eventos.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\EventoController::class,
            'store',
            \App\Http\Requests\Api\EventoControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $titulo = $this->faker->word();
        $descripcion = $this->faker->text();
        $max_inscritos = $this->faker->numberBetween(-10000, 10000);
        $tipo_usuario = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('eventos.store'), [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'max_inscritos' => $max_inscritos,
            'tipo_usuario' => $tipo_usuario,
        ]);

        $eventos = Evento::query()
            ->where('titulo', $titulo)
            ->where('descripcion', $descripcion)
            ->where('max_inscritos', $max_inscritos)
            ->where('tipo_usuario', $tipo_usuario)
            ->get();
        $this->assertCount(1, $eventos);
        $evento = $eventos->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $evento = Evento::factory()->create();

        $response = $this->get(route('eventos.show', $evento));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $evento = Evento::factory()->create();

        $response = $this->put(route('eventos.update', $evento));

        $evento->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $evento = Evento::factory()->create();

        $response = $this->delete(route('eventos.destroy', $evento));

        $response->assertNoContent();

        $this->assertModelMissing($evento);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('eventos.error'));

        $response->assertNoContent(400);
    }
}
