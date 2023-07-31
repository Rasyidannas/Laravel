<?php

namespace App\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;

    use SoftDeletes;

    public function blogPost()
    {

        return $this->belongsTo('App\Models\BlogPost');
        // this is for custom table
        // return $this->belongsTo('App\Models\BlogPost', 'post_id', 'blog_post_id');
    }
    
    public static function booted(): void
    {
        //apply global scope
        static::addGlobalScope(new LatestScope);
    }
}
