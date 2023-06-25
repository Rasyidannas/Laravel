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
    public function testNoBlogPostWhenNothingInDatabase()
    {
        //act
        $response = $this->get('/posts');

        //assert
        // $response->assertSeeText('Blog post was deleted!');
    }

    public function testSee1BlogPostsWhenThereIs1()
    {
        //arrange
        $post = $this->createDummyBlogpost();

        // act
        $response = $this->get('/posts');

        //assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');

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
            ->assertStatus(302) //this status succes redirect page
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function teststoreFail()
    {
        //arrange
        $params = [
            'title' => 'a',
            'content' => 'a',
        ];

        //act & assert
        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        // dd($messages->getMessages());

        $this->assertEquals($messages['title'][0], 'The title field must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content field must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        //arrange
        $post = $this->createDummyBlogpost();

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed',
        ];

        //assert
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the Blog post'
        ]); //this is shortcut make $post to array

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the Blog post'
        ]); //this is shortcut make $post to array
        $this->assertDatabaseHas('blog_posts', $params); //this is shortcut make $post to array
    }

    public function testDeleted()
    {
        //arrange
        $post = $this->createDummyBlogpost();
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the Blog post'
        ]);
        
        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

            $this->assertEquals(session('status'), 'Blog post was deleted!');
            $this->assertDatabaseMissing('blog_posts', [
                'title' => 'New Title',
                'content' => 'Content of the Blog post'
            ]); //this is shortcut make $post to array
    }

    //this is call instatiate Blogpost model with fill it
    private function createDummyBlogpost(): Blogpost
    {
        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'Content of the Blog post';
        $post->save();

        return $post;
    }
}
