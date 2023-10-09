<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use App\Models\BlogPost;
use Faker\Core\Blood;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'es' => 'Espanol',
        'de' => 'Deutsch'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'is_admin',
        'locale'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function BlogPosts()
    {
        return $this->hasMany('App\Models\BlogPost');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function commentsOn()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();//this latest() from local scope and this is second away
    }


    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeWithMostBlogposts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc'); //blog_post_count will be new field cause orderBy
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->withCount(['blogPosts' => function (Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->has('blogPosts', '>=', 2)//yang memiliki blogpost lebih dari sama dengan 2
            ->orderBy('blog_posts_count', 'desc'); //blog_post_count will be new field cause orderBy
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post) 
    {
        return $query->whereHas('comments', function($query) use($post){
            return $query->where('commentable_id', '=', $post->id)
                    ->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeThatIsAnAdmin(Builder $query)
    {
        return $query->where('is_admin', true);
    }
}
