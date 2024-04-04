<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Stop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\StopController
 */
final class StopControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_responds_with(): void
    {
        $stops = Stop::factory()->count(3)->create();

        $response = $this->get(route('stops.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $response = $this->post(route('stops.store'));

        $response->assertNoContent(201);

        $this->assertDatabaseHas(stops, [ /* ... */ ]);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $stop = Stop::factory()->create();

        $response = $this->get(route('stops.show', $stop));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $stop = Stop::factory()->create();

        $response = $this->put(route('stops.update', $stop));

        $stop->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $stop = Stop::factory()->create();

        $response = $this->delete(route('stops.destroy', $stop));

        $response->assertNoContent();

        $this->assertModelMissing($stop);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('stops.error'));

        $response->assertNoContent(400);
    }
}
