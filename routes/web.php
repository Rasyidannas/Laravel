<?php

use Illuminate\Http\Request;
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
    // dd(request()->all());//this will call all request in url (/posts?page=2)
    // dd(request()->query('page'));//this will call all request in url (/posts?page=2)
    return view('posts.index', ['posts' => $posts]);
});

//this {id} as a parameters and where is for constraints/limit 
Route::get('/posts/{id}', function ($id) use ($posts) {

    //this is will be go 404 page when id prameters is not match with $posts
    abort_if(!isset($posts[$id]), 404);

    // THis is Rendering with vies and store data in template
    return view('posts.show', ['post' => $posts[$id]]);
})->name('posts.show');

//this ? is an optional parameters with default value
Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Post from ' . $daysAgo . ' days ago';
})->name('post.recent.index');

// this is grouping route
Route::prefix('/fun')->name('fun.')->group(function() use($posts){
    Route::get('response', function () use ($posts) {
        return response($posts, 201)
            ->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Rasyid Annas', 3600);
    })->name('responses');
    
    //this is for redirect/force visit page you want
    Route::get('redirect', function() {
        return redirect('/contact');
    })->name('redirect');
    
    // this will back to the previous page
    Route::get('back', function() {
        return back();
    })->name('back');
    
    Route::get('named-route', function() {
        return redirect()->route('posts.show', ['id' => 1]);//posts.show is route name
    })->name('named-route');
    
    //this is for riderect to outside domain
    Route::get('away', function() {
        return redirect()->away('https://google.com');
    })->name('away');
    
    // this is will automatically return JSON
    Route::get('json', function() use($posts) {
        return response()->json($posts);
    })->name('json');
    
    Route::get('download', function() {
        return response()->download(public_path('/Creativesshits.png'), 'portfolio.png');//this will be donwload file in public
    })->name('download');
});    

