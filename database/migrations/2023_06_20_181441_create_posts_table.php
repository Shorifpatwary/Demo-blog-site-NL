<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('posts', function (Blueprint $table) {
			$table->id();
			$table->string('title', 150);
			$table->string('slug', 150)->unique();
			$table->text('content');
			$table->string('status');
			$table->date('published_at');
			$table->integer('views');
			$table->boolean('comments_enabled')->default(1);
			$table->string('meta_title');
			$table->text('meta_description');
			$table->string('excerpt');

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
