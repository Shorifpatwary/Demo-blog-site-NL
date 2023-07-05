<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
  use HasFactory;
  protected $fillable = [
    'title', 'slug', 'content', 'status', 'published_at', 'views', 'comments_enabled', 'meta_title', 'meta_description', 'excerpt', 'user_id'
  ];
  // relations 
  public function comment(): HasMany
  {
    return $this->hasMany(Comment::class);
  }
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
  public function category(): BelongsToMany
  {
    return $this->belongsToMany(Category::class);
  }
  public function tag(): BelongsToMany
  {
    return $this->belongsToMany(Tag::class);
  }
}