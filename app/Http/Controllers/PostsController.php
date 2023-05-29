<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class PostsController extends Controller
{
    private $posts = [
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // orderBy is a query builder
        // return view('posts.index', ['posts' => BlogPost::orderBy('created_at', 'desc')->take(5)->get()]);
        return view('posts.index', ['posts' => BlogPost::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // for 404 page if posts id is wrong
        // abort_if(!isset($this->posts[$id]), 404);

        //faindOrFail is a collection ORM Laravel
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
