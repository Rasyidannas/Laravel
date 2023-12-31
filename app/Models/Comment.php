<?php

namespace App\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    //this is local scope
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }


    public static function booted(): void
    {
        //apply global scope
        // static::addGlobalScope(new LatestScope);
    }
}
