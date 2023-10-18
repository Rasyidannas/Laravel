<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function testNewBlogPostDoesNotHaveComments(): void
    {
        $post = new BlogPost();

        //create post don't have comment
        $post::factory()->create([
            'user_id' => $this->user()->id //this is from TestCase.php(parent this class)
        ]);

        //this for API test
        $response = $this->getJson('/api/v1/posts/1/comments');
        $response->assertStatus(200)
            ->assertJsonStructure(['data']) //this for check sturcture JSON has 'data'
            ->assertJsonCount(0, 'data'); //for check "data is empty comment
    }

    public function testBlogPostHas10Comments()
    {
        $post = new BlogPost();
        $comment = new Comment();

        //create post with 10 comments
        $post::factory()->create([
            'user_id' => $this->user()->id //this is from TestCase.php(parent this class)
        ])->each(function (BlogPost $post) use ($comment) {
            $post->comments()->saveMany(
                $comment::factory()->count(10)->make([
                    'user_id' => $this->user()->id
                ])
            );
        });

        //this for API test
        $response = $this->getJson('/api/v1/posts/2/comments');
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'comment_id', 
                    'content', 
                    'created_at', 
                    'updated_at', 
                    'user' => [
                        'id', 
                        'name'
                        ]
                    ]
                ]]) //this for check sturcture JSON has 'data'
            ->assertJsonCount(10, 'data'); //for check "data is empty comment
    }
}
