<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Monument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\MonumentController
 */
final class MonumentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $monuments = Monument::factory()->count(3)->create();

        $response = $this->get(route('monuments.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\MonumentController::class,
            'store',
            \App\Http\Requests\Api\MonumentControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $title = $this->faker->sentence(4);
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $creation_date = Carbon::parse($this->faker->date());
        $main_image = $this->faker->word();
        $latitude = $this->faker->latitude();
        $longitude = $this->faker->longitude();
        $meaning = $this->faker->text();

        $response = $this->post(route('monuments.store'), [
            'title' => $title,
            'type' => $type,
            'creation_date' => $creation_date,
            'main_image' => $main_image,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'meaning' => $meaning,
        ]);

        $monuments = Monument::query()
            ->where('title', $title)
            ->where('type', $type)
            ->where('creation_date', $creation_date)
            ->where('main_image', $main_image)
            ->where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->where('meaning', $meaning)
            ->get();
        $this->assertCount(1, $monuments);
        $monument = $monuments->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $monument = Monument::factory()->create();

        $response = $this->get(route('monuments.show', $monument));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $monument = Monument::factory()->create();

        $response = $this->put(route('monuments.update', $monument));

        $monument->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $monument = Monument::factory()->create();

        $response = $this->delete(route('monuments.destroy', $monument));

        $response->assertNoContent();

        $this->assertModelMissing($monument);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('monuments.error'));

        $response->assertNoContent(400);
    }
}
