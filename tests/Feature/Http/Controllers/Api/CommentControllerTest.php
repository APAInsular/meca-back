<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\CommentController
 */
final class CommentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $comments = Comment::factory()->count(3)->create();

        $response = $this->get(route('comments.index'));

        $response->assertOk();
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CommentController::class,
            'store',
            \App\Http\Requests\Api\CommentControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $content = $this->faker->paragraphs(3, true);
        $main_image = $this->faker->word();

        $response = $this->post(route('comments.store'), [
            'content' => $content,
            'main_image' => $main_image,
        ]);

        $comments = Comment::query()
            ->where('content', $content)
            ->where('main_image', $main_image)
            ->get();
        $this->assertCount(1, $comments);
        $comment = $comments->first();

        $response->assertNoContent(201);
    }


    #[Test]
    public function show_responds_with(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comments.show', $comment));

        $response->assertOk();
    }


    #[Test]
    public function update_responds_with(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->put(route('comments.update', $comment));

        $comment->refresh();

        $response->assertOk();
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->delete(route('comments.destroy', $comment));

        $response->assertNoContent();

        $this->assertModelMissing($comment);
    }


    #[Test]
    public function error_responds_with(): void
    {
        $response = $this->get(route('comments.error'));

        $response->assertNoContent(400);
    }
}
