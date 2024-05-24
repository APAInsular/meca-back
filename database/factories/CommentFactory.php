<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\User;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
            'main_image' => $this->faker->imageUrl(),
            'user_id' => User::factory(),
            'commentable_id' => $this->faker->numberBetween(1, 5),
            'commentable_type' => 'App/Models/Monument',
        ];
    }
}
