<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Calificacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\CalificacionController
 */
final class CalificacionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $calificacions = Calificacion::factory()->count(3)->create();

        $response = $this->get(route('calificacions.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CalificacionController::class,
            'store',
            \App\Http\Requests\Api\CalificacionControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $calificación = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('calificacions.store'), [
            'calificación' => $calificación,
        ]);

        $calificacions = Calificacion::query()
            ->where('calificación', $calificación)
            ->get();
        $this->assertCount(1, $calificacions);
        $calificacion = $calificacions->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $calificacion = Calificacion::factory()->create();

        $response = $this->get(route('calificacions.show', $calificacion));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $calificacion = Calificacion::factory()->create();

        $response = $this->put(route('calificacions.update', $calificacion));

        $calificacion->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $calificacion = Calificacion::factory()->create();

        $response = $this->delete(route('calificacions.destroy', $calificacion));

        $response->assertNoContent();

        $this->assertModelMissing($calificacion);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('calificacions.error'));

        $response->assertNoContent(400);
    }
}
