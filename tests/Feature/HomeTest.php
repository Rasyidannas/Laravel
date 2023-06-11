<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHomePageIsWorkingCorrectly(): void
    {
        // act
        $response = $this->get('/');
        // assert
        $response->assertStatus(200);
        // this is assert for check words in page
        $response->assertSeeText("Welcome to Laravel!");
        $response->assertSeeText("This is the content of the main page!");
    }

    public function testContactPageIsWirkingCorrectly()
    {
        //act
        $response = $this->get('/contact');
        //assert
        $response->assertSeeText("Contact");
        $response->assertSeeText("Hello this is contact!");
    }
}
