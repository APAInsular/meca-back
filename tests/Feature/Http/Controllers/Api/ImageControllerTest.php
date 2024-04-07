<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ImageController
 */
final class ImageControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $images = Image::factory()->count(3)->create();

        $response = $this->get(route('images.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ImageController::class,
            'store',
            \App\Http\Requests\Api\ImageControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $url = $this->faker->url();

        $response = $this->post(route('images.store'), [
            'url' => $url,
        ]);

        $images = Image::query()
            ->where('url', $url)
            ->get();
        $this->assertCount(1, $images);
        $image = $images->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $image = Image::factory()->create();

        $response = $this->get(route('images.show', $image));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $image = Image::factory()->create();

        $response = $this->put(route('images.update', $image));

        $image->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $image = Image::factory()->create();

        $response = $this->delete(route('images.destroy', $image));

        $response->assertNoContent();

        $this->assertModelMissing($image);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('images.error'));

        $response->assertNoContent(400);
    }
}
