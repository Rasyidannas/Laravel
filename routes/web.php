<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserController;
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
//this is using controller
Route::get('/', [HomeController::class, 'home'])->name('home.index')
    // ->middleware('auth')//middleware is for only user login/authenticated
;

//this is using controller
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::get('/secret', [HomeController::class, 'secret'])
    ->name('home.secret')
    ->middleware('can:home.secret'); //this is for authorization

//this is single action controllers
Route::get('/single', AboutController::class);

Route::resource('posts', PostsController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

// this is grouping route
// Route::prefix('/fun')->name('fun.')->group(function() use($posts){
//     Route::get('response', function () use ($posts) {
//         return response($posts, 201)
//             ->header('Content-Type', 'application/json')
//             ->cookie('MY_COOKIE', 'Rasyid Annas', 3600);
//     })->name('responses');

//     //this is for redirect/force visit page you want
//     Route::get('redirect', function() {
//         return redirect('/contact');
//     })->name('redirect');

//     // this will back to the previous page
//     Route::get('back', function() {
//         return back();
//     })->name('back');

//     Route::get('named-route', function() {
//         return redirect()->route('posts.show', ['id' => 1]);//posts.show is route name
//     })->name('named-route');

//     //this is for riderect to outside domain
//     Route::get('away', function() {
//         return redirect()->away('https://google.com');
//     })->name('away');

//     // this is will automatically return JSON
//     Route::get('json', function() use($posts) {
//         return response()->json($posts);
//     })->name('json');

//     Route::get('download', function() {
//         return response()->download(public_path('/Creativesshits.png'), 'portfolio.png');//this will be donwload file in public
//     })->name('download');
// });    


//1. composer require laravel/ui
//2. php artisan ui:controllers
//this is for authentication route but we need install above commands
Auth::routes();
