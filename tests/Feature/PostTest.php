<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    //this is for reseting database after testing
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testNoBlogPostWhenNothingInDatabase(): void
    {
        //act
        $response = $this->get('/posts');

        //assert
        // $response->assertSeeText('Blog post was deleted!');
    }

    public function testSee1BlogPostsWhenThereIs1()
    {
        //arrange
        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'Content of the Blog post';
        $post->save();

        // act
        $response = $this->get('/posts');

        //assert
        $response->assertSeeText('New Title');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the Blog post'
        ]);
    }

    public function testStoreValid()
    {
        //arrange
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];
        
        //act & assert
        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }
}
