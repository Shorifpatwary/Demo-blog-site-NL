<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
	use HasFactory;

	protected $fillable = [
		'name', 'slug', 'description', 'image'
	];

	public function post(): BelongsToMany
	{
		return $this->belongsToMany(Post::class);
	}
}
