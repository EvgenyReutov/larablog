<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => function() {
                $user = User::all()->random();
                if (empty(($user))) {
                    $user = User::factory();
                }
                return $user;
            },
            'text' => $this->faker->paragraph(2),
            'post_id' => Post::factory(),
        ];
    }
}
