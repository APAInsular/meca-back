<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\QR;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\QRController
 */
final class QRControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $qRs = QR::factory()->count(3)->create();

        $response = $this->get(route('q-rs.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\QRController::class,
            'store',
            \App\Http\Requests\Api\QRControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $ruta = $this->faker->word();
        $imagen = $this->faker->word();

        $response = $this->post(route('q-rs.store'), [
            'ruta' => $ruta,
            'imagen' => $imagen,
        ]);

        $qRs = QR::query()
            ->where('ruta', $ruta)
            ->where('imagen', $imagen)
            ->get();
        $this->assertCount(1, $qRs);
        $qR = $qRs->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $qR = QR::factory()->create();

        $response = $this->get(route('q-rs.show', $qR));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $qR = QR::factory()->create();

        $response = $this->put(route('q-rs.update', $qR));

        $qR->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $qR = QR::factory()->create();

        $response = $this->delete(route('q-rs.destroy', $qR));

        $response->assertNoContent();

        $this->assertModelMissing($qR);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('q-rs.error'));

        $response->assertNoContent(400);
    }
}
