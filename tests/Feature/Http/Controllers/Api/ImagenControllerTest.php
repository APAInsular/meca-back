<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Imagen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ImagenController
 */
final class ImagenControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $imagens = Imagen::factory()->count(3)->create();

        $response = $this->get(route('imagens.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ImagenController::class,
            'store',
            \App\Http\Requests\Api\ImagenControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $url = $this->faker->url();

        $response = $this->post(route('imagens.store'), [
            'url' => $url,
        ]);

        $imagens = Imagen::query()
            ->where('url', $url)
            ->get();
        $this->assertCount(1, $imagens);
        $imagen = $imagens->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $imagen = Imagen::factory()->create();

        $response = $this->get(route('imagens.show', $imagen));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $imagen = Imagen::factory()->create();

        $response = $this->put(route('imagens.update', $imagen));

        $imagen->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $imagen = Imagen::factory()->create();

        $response = $this->delete(route('imagens.destroy', $imagen));

        $response->assertNoContent();

        $this->assertModelMissing($imagen);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('imagens.error'));

        $response->assertNoContent(400);
    }
}
