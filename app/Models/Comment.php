<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['user_id', 'content'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
        // this is for custom table
        // return $this->belongsTo('App\Models\BlogPost', 'post_id', 'blog_post_id');
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    //this is local scope
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function booted(): void
    {
        //apply global scope
        // static::addGlobalScope(new LatestScope);

        //this is for create connect with cache
        static::creating(function (Comment $comment) {
            if ($comment->commentable_type === BlogPost::class) {
                //this is for deleting cache 
                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
                Cache::tags(['blog-post'])->forget("mostCommented");
            }
        });
    }
}
