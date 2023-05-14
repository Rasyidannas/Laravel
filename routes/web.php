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
Route::get('/', function () {
    return 'Home page';
})->name('home.index');

Route::get('/contact', function () {
    return 'Contact';
})->name('home.contact');

//this {id} as a parameters and where is for constraints/limit 
Route::get('/posts/{id}', function ($id) {
    return 'Blog post ' . $id;
})
// ->where([
//     'id' => '[0-9]+'
// ])
->name('post.show');

//this ? is an optional parameters with default value
Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Post from ' . $daysAgo . ' days ago';
})->name('post.recent.index');
