<?php

namespace App\Models;

use App\Models\BlogPost as ModelsBlogPost;
use App\Models\Scopes\DeletedAdminScope;
use App\Models\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes, Taggable;

    protected $fillable = ['title', 'content', 'user_id'];

    use HasFactory;

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();//this latest() from local scope and this is second away
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    //this is local scope
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    //this is local scope
    public function scopeMostCommented(Builder $query)
    {
        //comments_count will be new field cause orderBy
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    //this is local scope
    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
                ->withCount('comments')
                ->with('user')
                ->with('tags');
    }

    public static function booted(): void
    {
        //apply global scope
        static::addGlobalScope(new DeletedAdminScope);
    }
}
