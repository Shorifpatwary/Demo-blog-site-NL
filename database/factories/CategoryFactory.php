<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
		} while (\App\Models\Category::where('name', $name)->exists());

		return [
			'name' => $name,
			'description' => fake()->sentence(25),
			'slug' => Str::slug($name),
			'image' => fake()->imageUrl(640, 480, 'animals', true),
		];
	}
}
