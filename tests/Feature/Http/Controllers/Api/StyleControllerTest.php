<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\StyleController
 */
final class StyleControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $styles = Style::factory()->count(3)->create();

        $response = $this->get(route('styles.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\StyleController::class,
            'store',
            \App\Http\Requests\Api\StyleControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('styles.store'), [
            'name' => $name,
        ]);

        $styles = Style::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $styles);
        $style = $styles->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $style = Style::factory()->create();

        $response = $this->get(route('styles.show', $style));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $style = Style::factory()->create();

        $response = $this->put(route('styles.update', $style));

        $style->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $style = Style::factory()->create();

        $response = $this->delete(route('styles.destroy', $style));

        $response->assertNoContent();

        $this->assertModelMissing($style);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('styles.error'));

        $response->assertNoContent(400);
    }
}
