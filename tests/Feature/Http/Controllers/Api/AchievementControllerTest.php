<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\AchievementController
 */
final class AchievementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $achievements = Achievement::factory()->count(3)->create();

        $response = $this->get(route('achievements.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\AchievementController::class,
            'store',
            \App\Http\Requests\Api\AchievementControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $time = Carbon::parse($this->faker->dateTime());

        $response = $this->post(route('achievements.store'), [
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'time' => $time,
        ]);

        $achievements = Achievement::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('status', $status)
            ->where('time', $time)
            ->get();
        $this->assertCount(1, $achievements);
        $achievement = $achievements->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $achievement = Achievement::factory()->create();

        $response = $this->get(route('achievements.show', $achievement));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $achievement = Achievement::factory()->create();

        $response = $this->put(route('achievements.update', $achievement));

        $achievement->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $achievement = Achievement::factory()->create();

        $response = $this->delete(route('achievements.destroy', $achievement));

        $response->assertNoContent();

        $this->assertModelMissing($achievement);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('achievements.error'));

        $response->assertNoContent(400);
    }
}
