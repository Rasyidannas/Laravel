<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Facades\CounterFacade;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:web');//this is for only user login/authenticated in website using session in auth.php
        $this->middleware('auth:web')->only(['create', 'store', 'edit', 'update', 'destroy']);
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


        return view('posts.index', [
            'posts' => BlogPost::latestWithRelations()->get()
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
        $blogPost = BlogPost::create($validated);

        //File Storage
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $blogPost->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPosted($blogPost));

        // success session
        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $blogPost->id]);
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

        $blogpost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function () use ($id) {
            //comments.user is nested relationship (comments relationship to user)
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                ->findOrFail($id);
        });

        //this is for count user viewing/watching and using  service container
        // $counter = resolve(Counter::class);

        //faindOrFail is a collection ORM Laravel
        return view('posts.show', [
            'post' => $blogpost,
            'counter' => CounterFacade::increment("blog-post{$id}", ['blog-post'])
        ]);
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

        //File Storage
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::create(['path' => $path])
                );
            }
        }

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
