<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\RatingController
 */
final class RatingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $ratings = Rating::factory()->count(3)->create();

        $response = $this->get(route('ratings.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\RatingController::class,
            'store',
            \App\Http\Requests\Api\RatingControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $rating = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('ratings.store'), [
            'rating' => $rating,
        ]);

        $ratings = Rating::query()
            ->where('rating', $rating)
            ->get();
        $this->assertCount(1, $ratings);
        $rating = $ratings->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->get(route('ratings.show', $rating));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->put(route('ratings.update', $rating));

        $rating->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->delete(route('ratings.destroy', $rating));

        $response->assertNoContent();

        $this->assertModelMissing($rating);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('ratings.error'));

        $response->assertNoContent(400);
    }
}
