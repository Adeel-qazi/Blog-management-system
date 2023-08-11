<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function posts(){  // we have a category and each category has many blog post
     return $this->hasMany(Post::class);
    }
}
  