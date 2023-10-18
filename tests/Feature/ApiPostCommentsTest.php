<?php

namespace Tests\Feature;

use App\Models\BlogPost;
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
            ->assertJsonStructure(['data'])//this for check sturcture JSON has 'data'
            ->assertJsonCount(0, 'data');//for check "data is empty comment
    }
}
