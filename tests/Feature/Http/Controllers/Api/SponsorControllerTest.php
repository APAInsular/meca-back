<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\SponsorController
 */
final class SponsorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $sponsors = Sponsor::factory()->count(3)->create();

        $response = $this->get(route('sponsors.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\SponsorController::class,
            'store',
            \App\Http\Requests\Api\SponsorControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $name = $this->faker->name();
        $sponsor_code = $this->faker->word();
        $point_of_interest = $this->faker->word();

        $response = $this->post(route('sponsors.store'), [
            'name' => $name,
            'sponsor_code' => $sponsor_code,
            'point_of_interest' => $point_of_interest,
        ]);

        $sponsors = Sponsor::query()
            ->where('name', $name)
            ->where('sponsor_code', $sponsor_code)
            ->where('point_of_interest', $point_of_interest)
            ->get();
        $this->assertCount(1, $sponsors);
        $sponsor = $sponsors->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $sponsor = Sponsor::factory()->create();

        $response = $this->get(route('sponsors.show', $sponsor));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $sponsor = Sponsor::factory()->create();

        $response = $this->put(route('sponsors.update', $sponsor));

        $sponsor->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $sponsor = Sponsor::factory()->create();

        $response = $this->delete(route('sponsors.destroy', $sponsor));

        $response->assertNoContent();

        $this->assertModelMissing($sponsor);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('sponsors.error'));

        $response->assertNoContent(400);
    }
}
