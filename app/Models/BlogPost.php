<?php

namespace App\Models;

use App\Models\BlogPost as ModelsBlogPost;
use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];
    
    use HasFactory;

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function booted(): void
    {
        //apply global scope
        static::addGlobalScope(new LatestScope);

        //this is for delete comments(foreign key) and it can related to comments for soft deleted
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        //this is for restore soft delete for blogpost and comments table
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
