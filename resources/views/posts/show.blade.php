{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', $post->title)

{{-- This will put in @yield('content') --}}
@section('content')
    
    <h1>
        {{ $post->title }}
        {{-- This is usig component --}}
        <x-badge :show="now()->diffInMinutes($post->created_at) < 5">
            Brand new post!
        </x-badge>
    </h1>
    <p>{{ $post->content }}</p>
    {{-- this is using component  --}}
    <x-updated :date="$post->created_at" :name="$post->user->name" />
    <x-updated :date="$post->updated_at" :name="$post->user->name">Updated</x-updated>

    <p>Currently read by {{ $counter }} people</p>

    <h1>Comments</h1>

    @forelse($post->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        
        <p class="text-muted">
            {{-- this is using component  --}}
            <x-updated :date="$comment->created_at"/>
        </p>
    @empty 
        <p>No comments yet!</p>
    
    @endforelse
@endsection