<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    //this is for update connect with cache
    public function updating(BlogPost $blogPost): void
    {
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
    }

    //this is for delete comments(foreign key) and it can related to comments for soft deleted
    public function deleting(BlogPost $blogPost)
    {
        $blogPost->comments()->delete();
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
    }

    //this is for restore soft delete for blogpost and comments table
    public function restoring(BlogPost $blogPost): void
    {
        $blogPost->comments()->restore();
    }
}
