<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\EventController
 */
final class EventControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $events = Event::factory()->count(3)->create();

        $response = $this->get(route('events.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\EventController::class,
            'store',
            \App\Http\Requests\Api\EventControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $max_attendees = $this->faker->numberBetween(-10000, 10000);
        $user_type = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('events.store'), [
            'title' => $title,
            'description' => $description,
            'max_attendees' => $max_attendees,
            'user_type' => $user_type,
        ]);

        $events = Event::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('max_attendees', $max_attendees)
            ->where('user_type', $user_type)
            ->get();
        $this->assertCount(1, $events);
        $event = $events->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $event = Event::factory()->create();

        $response = $this->put(route('events.update', $event));

        $event->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $event = Event::factory()->create();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertNoContent();

        $this->assertModelMissing($event);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('events.error'));

        $response->assertNoContent(400);
    }
}
