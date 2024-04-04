<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\BlogEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\BlogEntryController
 */
final class BlogEntryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $blogEntries = BlogEntry::factory()->count(3)->create();

        $response = $this->get(route('blog-entries.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\BlogEntryController::class,
            'store',
            \App\Http\Requests\Api\BlogEntryControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $description = $this->faker->text();
        $main_image = $this->faker->word();

        $response = $this->post(route('blog-entries.store'), [
            'title' => $title,
            'content' => $content,
            'description' => $description,
            'main_image' => $main_image,
        ]);

        $blogEntries = BlogEntry::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('description', $description)
            ->where('main_image', $main_image)
            ->get();
        $this->assertCount(1, $blogEntries);
        $blogEntry = $blogEntries->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $blogEntry = BlogEntry::factory()->create();

        $response = $this->get(route('blog-entries.show', $blogEntry));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $blogEntry = BlogEntry::factory()->create();

        $response = $this->put(route('blog-entries.update', $blogEntry));

        $blogEntry->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $blogEntry = BlogEntry::factory()->create();

        $response = $this->delete(route('blog-entries.destroy', $blogEntry));

        $response->assertNoContent();

        $this->assertModelMissing($blogEntry);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('blog-entries.error'));

        $response->assertNoContent(400);
    }
}
