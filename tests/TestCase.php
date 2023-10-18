<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use App\Models\BlogPost;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user()
    {
        $user = new User();

        return $user::factory()->create();
    }

    protected function blogPost()
    {
        $post = new BlogPost();

        //create post don't have comment
        return $post::factory()->create([
            'user_id' => $this->user()->id //this is from TestCase.php(parent this class)
        ]);
    }
}
