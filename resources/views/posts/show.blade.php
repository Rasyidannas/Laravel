{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', $post->title)

{{-- This will put in @yield('content') --}}
@section('content')
    
    <h1>
        {{ $post->title }}
        <x-badge :show="now()->diffInMinutes($post->created_at) < 5">
            Brand new post!
        </x-badge>
    </h1>
    <p>{{ $post->content }}</p>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>


    <h1>Comments</h1>

    @forelse($post->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        
        <p class="text-muted">
            added {{ $comment->created_at->diffForHumans() }}
        </p>
    @empty 
        <p>No comments yet!</p>
    
    @endforelse
@endsection