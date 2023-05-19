<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//name is for naming in php artisan route:list
//this is simple view rendering
Route::view('/', 'home.index')->name('home.index');

//this is simple view rendering
Route::view('/contact', 'home.contact')->name('home.contact');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is short intro to PHP',
        'is_new' => false
    ],
    3 => [
        'title' => 'Intro to Golang',
        'content' => 'This is short intro to Golang',
        'is_new' => false
    ]
];

Route::get('/posts', function () use ($posts) {
    return view('posts.index', ['posts' => $posts]);
});

//this {id} as a parameters and where is for constraints/limit 
Route::get('/posts/{id}', function ($id) use ($posts) {

    //this is will be go 404 page when id prameters is not match with $posts
    abort_if(!isset($posts[$id]), 404);

    // THis is Rendering with vies and store data in template
    return view('posts.show', ['post' => $posts[$id]]);
})->name('post.show');

//this ? is an optional parameters with default value
Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Post from ' . $daysAgo . ' days ago';
})->name('post.recent.index');

Route::get('/fun/response', function () use ($posts) {
    return response($posts, 201)
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'Rasyid Annas', 3600);
});
