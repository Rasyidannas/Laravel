<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content'];
    
    use HasFactory;

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    //this is for delete comments(foreign key)
    // public static function booted(): void
    // {
    //     static::deleting(function (BlogPost $blogPost) {
    //         $blogPost->comments()->delete();
    //     });
    // }
}
