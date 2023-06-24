<?php

namespace Database\Seeders;

use App\Models\TagPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TagPost::factory()->count(50)->create();
    }
}