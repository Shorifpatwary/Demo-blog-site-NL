<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryPost>
 */
class CategoryPostFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'category_id' => Category::pluck('id')->random(),
			'post_id' => Post::pluck('id')->random(),
		];
	}
}
