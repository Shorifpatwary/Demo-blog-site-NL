<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call([
			UserSeeder::class,
			CountrySeeder::class,
			StateSeeder::class,
			CitySeeder::class,
			DepartmentSeeder::class,
			EmployeeSeeder::class,
			CategorySeeder::class,
			TagSeeder::class,
			PostSeeder::class,
			CategoryPostSeeder::class,
			TagPostSeeder::class,
			CommentSeeder::class,
		]);
	}
}
