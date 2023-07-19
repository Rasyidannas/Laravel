<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\BlogPost;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = BlogPost::all();
        
        if($posts->count() === 0) {
            $this->command->info('There are no blogposts, so no comments will be added');
            return;
        }

        $commentCount = (int)$this->command->ask('How many users would you like?', 70);

        Comment::factory()->count($commentCount)->make()->each(function ($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
