<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\SubAchievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\SubAchievementController
 */
final class SubAchievementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $subAchievements = SubAchievement::factory()->count(3)->create();

        $response = $this->get(route('sub-achievements.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\SubAchievementController::class,
            'store',
            \App\Http\Requests\Api\SubAchievementControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $time = Carbon::parse($this->faker->dateTime());

        $response = $this->post(route('sub-achievements.store'), [
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'time' => $time,
        ]);

        $subAchievements = SubAchievement::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('status', $status)
            ->where('time', $time)
            ->get();
        $this->assertCount(1, $subAchievements);
        $subAchievement = $subAchievements->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $subAchievement = SubAchievement::factory()->create();

        $response = $this->get(route('sub-achievements.show', $subAchievement));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $subAchievement = SubAchievement::factory()->create();

        $response = $this->put(route('sub-achievements.update', $subAchievement));

        $subAchievement->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $subAchievement = SubAchievement::factory()->create();

        $response = $this->delete(route('sub-achievements.destroy', $subAchievement));

        $response->assertNoContent();

        $this->assertModelMissing($subAchievement);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('sub-achievements.error'));

        $response->assertNoContent(400);
    }
}
