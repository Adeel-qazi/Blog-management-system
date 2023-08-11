<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

      //write an eloquent relationship between user and post
    // we have a post and it belongs to one user
    // we have a post it belongs to one particulary category
    // $this refers to current model
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
      return $this->belongsTo(Category::class);
    }
}
