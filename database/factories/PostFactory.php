<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'text' => $this->faker->paragraph,
            'status' => collect([PostStatus::Active, PostStatus::Draft])->random(),
        ];
    }
}
