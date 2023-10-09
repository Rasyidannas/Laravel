<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        // dd($post->comments);
        //this will return json format
        return $post->comments()->with('user')->get();
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        event(new CommentPosted($comment));

        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment)
        // );

        // Mail::to($post->user)->queue(
            // new CommentPostedMarkdown($comment)
        // );

        // $when = now()->addMinutes(1);

        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        // success session
        // $request->session()->flash('status', 'Comment was created!');

        return redirect()->back()->withStatus('Comment was created!');
    }
}
