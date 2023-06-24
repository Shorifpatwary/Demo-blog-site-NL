<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
	public function definition(): array
	{
		$title = '';
		do {
			$title = fake()->unique()->sentence(12);
		} while (\App\Models\Post::where('title', $title)->exists());
		return [
			'title' => $title,
			'slug' => Str::slug($title),
			'content' => implode("\n\n", fake()->paragraphs()),
			'image' => fake()->imageUrl(640, 480, 'animals', true),
			'status' => fake()->randomElement(['draft', 'published']),
			'published_at' => fake()->dateTimeBetween('-2 year', '+1 month'),
			'views' => fake()->randomNumber(5, false),
			'comments_enabled' => fake()->boolean(),
			'meta_title' => fake()->sentence(10),
			'meta_description' => fake()->sentence(50),
			'excerpt' => fake()->sentence(10),
			'user_id' => User::pluck('id')->random(),
		];
	}
}