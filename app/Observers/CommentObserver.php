<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    //this is for create connect with cache
    public function creating(Comment $comment): void
    {
        if ($comment->commentable_type === BlogPost::class) {
            // dd("I am creating");
            //this is for deleting cache 
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog-post'])->forget("mostCommented");
        }
    }
}
