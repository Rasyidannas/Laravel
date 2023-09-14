<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\BlogPost;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = BlogPost::all();
        $users = User::all();
        
        if($posts->count() === 0 || $users->count() === 0) {
            $this->command->info('There are no blogposts, so no comments will be added');
            return;
        }

        $commentCount = (int)$this->command->ask('How many comments would you like?', 70);

        Comment::factory()->count($commentCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\Models\BlogPost';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory()->count($commentCount)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\Models\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
