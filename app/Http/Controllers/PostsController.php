<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');//this is for only user login/authenticated
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

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
        //this is usign cache for storing data and retrieving
        $mostCommented = Cache::remember('blog-post-commented', 60, function() {
            return BlogPost::mostCommented()->take(5)->get();
        });
        
        $mostActive = Cache::remember('users-most-active', 60, function() {
            return User::withMostBlogPosts()->take(5)->get();//this is call local scope
        });

        $mostActiveLastMonth = Cache::remember('users-most-active-last-month', 60, function() {
            return User::withMostBlogPostsLastMonth()->take(5)->get();//this is call local scope
        });

        return view('posts.index', [
            'posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
            'mostCommented' => $mostCommented, 
            'mostActive' => $mostActive,
            'mostActiveLastMonth' => $mostActiveLastMonth
        ]); //latest() this is from local scope in model
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // StorePost is Request custom
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        //this is Instatiate BlogPost model 
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        // $post->save();

        //this is for set user_id in form creat post
        $validated['user_id'] = $request->user()->id;

        // using mass assigment connect with model BlogPost
        $post = BlogPost::create($validated);

        // success session
        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // for 404 page if posts id is wrong
        // abort_if(!isset($this->posts[$id]), 404);

        //faindOrFail is a collection ORM Laravel
        // return view('posts.show', ['post' => BlogPost::with(['comments' => function($query) {
        //     return $query->latest(); //this is for call local scope with relationship this is first away
        // }])->findOrFail($id)]);

        $blogpost = Cache::remember("blog-post-{$id}", 60, function() use($id) {
            return BlogPost::with('comments')->findOrFail($id); 
        });

        //faindOrFail is a collection ORM Laravel
        return view('posts.show', ['post' => $blogpost]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);

        //this is for authorization
        // if (Gate::denies('posts.update', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }
        $this->authorize($post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id)
    {
        $post = BlogPost::findOrFail($id);

        //this is for authorization
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }

        //for short hand authorization
        $this->authorize($post);

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);

        //this is for authorization
        // if (Gate::denies($post)) {
        //     abort(403, "You can't delete this blog post!");
        // }

        //for short hand authorization
        $this->authorize($post);

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
