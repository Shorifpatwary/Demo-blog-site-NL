<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$name = '';
		do {
			$name = fake()->unique()->jobTitle();
		} while (\App\Models\Tag::where('name', $name)->exists());
		return [
			'name' => $name,
			'description' => fake()->sentence(25),
			'slug' => Str::slug($name),
			'image' => fake()->imageUrl(640, 480, 'animals', true),
			'post_id' => Post::pluck('id')->random(),
		];
	}
}