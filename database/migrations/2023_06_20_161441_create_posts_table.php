<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('posts', function (Blueprint $table) {
			$table->id();
			$table->string('title', 150);
			$table->string('slug', 160)->unique();
			$table->text('content')->nullable();
			$table->string('status')->default('published');
			$table->date('published_at')->nullable();
			$table->integer('views')->nullable()->default(1);
			$table->boolean('comments_enabled')->default(1);
			$table->string('meta_title')->nullable();
			$table->text('meta_description')->nullable();
			$table->string('excerpt')->nullable();
			$table->string('image', 200)->nullable()->unique();

			$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('posts');
	}
};