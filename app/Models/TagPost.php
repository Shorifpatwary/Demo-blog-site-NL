<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
  use HasFactory;
  protected $table = 'tag_post';
  protected $fillable = [
    'tag_id', 'post_id'
  ];
}
