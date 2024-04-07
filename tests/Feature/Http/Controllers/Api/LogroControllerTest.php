<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Logro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\LogroController
 */
final class LogroControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $logros = Logro::factory()->count(3)->create();

        $response = $this->get(route('logros.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\LogroController::class,
            'store',
            \App\Http\Requests\Api\LogroControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $titulo = $this->faker->word();
        $descripcion = $this->faker->text();
        $estado = $this->faker->randomElement(/** enum_attributes **/);
        $tiempo = Carbon::parse($this->faker->dateTime());

        $response = $this->post(route('logros.store'), [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'estado' => $estado,
            'tiempo' => $tiempo,
        ]);

        $logros = Logro::query()
            ->where('titulo', $titulo)
            ->where('descripcion', $descripcion)
            ->where('estado', $estado)
            ->where('tiempo', $tiempo)
            ->get();
        $this->assertCount(1, $logros);
        $logro = $logros->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $logro = Logro::factory()->create();

        $response = $this->get(route('logros.show', $logro));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $logro = Logro::factory()->create();

        $response = $this->put(route('logros.update', $logro));

        $logro->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $logro = Logro::factory()->create();

        $response = $this->delete(route('logros.destroy', $logro));

        $response->assertNoContent();

        $this->assertModelMissing($logro);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('logros.error'));

        $response->assertNoContent(400);
    }
}
