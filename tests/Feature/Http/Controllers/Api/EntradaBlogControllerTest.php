<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\EntradaBlog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\EntradaBlogController
 */
final class EntradaBlogControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $entradaBlogs = EntradaBlog::factory()->count(3)->create();

        $response = $this->get(route('entrada-blogs.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\EntradaBlogController::class,
            'store',
            \App\Http\Requests\Api\EntradaBlogControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $título = $this->faker->word();
        $contenido = $this->faker->text();
        $descripción = $this->faker->text();
        $imagen_principal = $this->faker->word();

        $response = $this->post(route('entrada-blogs.store'), [
            'título' => $título,
            'contenido' => $contenido,
            'descripción' => $descripción,
            'imagen_principal' => $imagen_principal,
        ]);

        $entradaBlogs = EntradaBlog::query()
            ->where('título', $título)
            ->where('contenido', $contenido)
            ->where('descripción', $descripción)
            ->where('imagen_principal', $imagen_principal)
            ->get();
        $this->assertCount(1, $entradaBlogs);
        $entradaBlog = $entradaBlogs->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $entradaBlog = EntradaBlog::factory()->create();

        $response = $this->get(route('entrada-blogs.show', $entradaBlog));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $entradaBlog = EntradaBlog::factory()->create();

        $response = $this->put(route('entrada-blogs.update', $entradaBlog));

        $entradaBlog->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $entradaBlog = EntradaBlog::factory()->create();

        $response = $this->delete(route('entrada-blogs.destroy', $entradaBlog));

        $response->assertNoContent();

        $this->assertModelMissing($entradaBlog);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('entrada-blogs.error'));

        $response->assertNoContent(400);
    }
}
