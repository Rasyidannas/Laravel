<?php

namespace App\Providers;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use App\Policies\BlogPostPolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',
        BlogPost::class => BlogPostPolicy::class,
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('home.secret', function (User $user) {
            return $user->is_admin;
        });

        // Gate::define('update-post', function(User $user, BlogPost $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('delete-post', function(User $user, BlogPost $post) {
        //     return $user->id === $post->user_id;
        // });

        //this is same with above
        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        //this is shorthand and same like above 
        Gate::resource('posts', 'App\Policies\BlogPostPolicy');

        //authorization for admin user
        Gate::before(function (User $user, string $ability) {
            if($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true;
            }
        });
        
        //authorization for admin user
        // Gate::after(function (User $user, string $ability, bool|null $result) {
        //     if($user->is_admin && in_array($ability, ['update-post'])) {
        //         return true;
        //     }
        // });
    }
}
