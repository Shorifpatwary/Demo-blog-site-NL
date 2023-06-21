<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;
  protected $fillable = [
    'title', 'slug', 'content', 'status', 'published_at', 'views', 'comments_enabled', 'meta_title', 'meta_description', 'excerpt', 'user_id'
  ];
}
