<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Comentario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ComentarioController
 */
final class ComentarioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $comentarios = Comentario::factory()->count(3)->create();

        $response = $this->get(route('comentarios.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ComentarioController::class,
            'store',
            \App\Http\Requests\Api\ComentarioControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $contenido = $this->faker->text();
        $imagen_principal = $this->faker->word();

        $response = $this->post(route('comentarios.store'), [
            'contenido' => $contenido,
            'imagen_principal' => $imagen_principal,
        ]);

        $comentarios = Comentario::query()
            ->where('contenido', $contenido)
            ->where('imagen_principal', $imagen_principal)
            ->get();
        $this->assertCount(1, $comentarios);
        $comentario = $comentarios->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $comentario = Comentario::factory()->create();

        $response = $this->get(route('comentarios.show', $comentario));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $comentario = Comentario::factory()->create();

        $response = $this->put(route('comentarios.update', $comentario));

        $comentario->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $comentario = Comentario::factory()->create();

        $response = $this->delete(route('comentarios.destroy', $comentario));

        $response->assertNoContent();

        $this->assertModelMissing($comentario);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('comentarios.error'));

        $response->assertNoContent(400);
    }
}
