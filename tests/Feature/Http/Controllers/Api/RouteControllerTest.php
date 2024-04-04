<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\RouteController
 */
final class RouteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $routes = Route::factory()->count(3)->create();

        $response = $this->get(route('routes.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\RouteController::class,
            'store',
            \App\Http\Requests\Api\RouteControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $name = $this->faker->name();
        $city = $this->faker->city();
        $distance = $this->faker->randomFloat(/** float_attributes **/);
        $time = $this->faker->time();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('routes.store'), [
            'name' => $name,
            'city' => $city,
            'distance' => $distance,
            'time' => $time,
            'status' => $status,
        ]);

        $routes = Route::query()
            ->where('name', $name)
            ->where('city', $city)
            ->where('distance', $distance)
            ->where('time', $time)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $routes);
        $route = $routes->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $route = Route::factory()->create();

        $response = $this->get(route('routes.show', $route));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $route = Route::factory()->create();

        $response = $this->put(route('routes.update', $route));

        $route->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $route = Route::factory()->create();

        $response = $this->delete(route('routes.destroy', $route));

        $response->assertNoContent();

        $this->assertModelMissing($route);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('routes.error'));

        $response->assertNoContent(400);
    }
}
