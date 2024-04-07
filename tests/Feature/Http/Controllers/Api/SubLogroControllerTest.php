<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\SubLogro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\SubLogroController
 */
final class SubLogroControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $subLogros = SubLogro::factory()->count(3)->create();

        $response = $this->get(route('sub-logros.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\SubLogroController::class,
            'store',
            \App\Http\Requests\Api\SubLogroControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $titulo = $this->faker->word();
        $descripcion = $this->faker->text();
        $estado = $this->faker->randomElement(/** enum_attributes **/);
        $tiempo = Carbon::parse($this->faker->dateTime());

        $response = $this->post(route('sub-logros.store'), [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'estado' => $estado,
            'tiempo' => $tiempo,
        ]);

        $subLogros = SubLogro::query()
            ->where('titulo', $titulo)
            ->where('descripcion', $descripcion)
            ->where('estado', $estado)
            ->where('tiempo', $tiempo)
            ->get();
        $this->assertCount(1, $subLogros);
        $subLogro = $subLogros->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $subLogro = SubLogro::factory()->create();

        $response = $this->get(route('sub-logros.show', $subLogro));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $subLogro = SubLogro::factory()->create();

        $response = $this->put(route('sub-logros.update', $subLogro));

        $subLogro->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $subLogro = SubLogro::factory()->create();

        $response = $this->delete(route('sub-logros.destroy', $subLogro));

        $response->assertNoContent();

        $this->assertModelMissing($subLogro);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('sub-logros.error'));

        $response->assertNoContent(400);
    }
}
