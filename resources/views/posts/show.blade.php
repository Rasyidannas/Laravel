{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', $post->title)

{{-- This will put in @yield('content') --}}
@section('content')
<div class="row">  
    <div class="col-8">
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

        <x-tags :tags="$post->tags" />

        <p>Currently read by {{ $counter }} people</p>

        {{-- <img src="{{ Storage::url($post->image->path) }}"/> --}}
        {{-- this is form Image Model using function url() --}}
        <img src="{{ $post->image->url() }}"/>

        <h1>Comments</h1>

        @include('comments.form')

        @forelse($post->comments as $comment)
            <p>
                {{ $comment->content }}
            </p>
            
            <p class="text-muted">
                {{-- this is using component  --}}
                <x-updated :date="$comment->created_at" :name="$comment->user->name" />
            </p>
        @empty 
            <p>No comments yet!</p>
        @endforelse
    </div>
    <div class="col-4">
        @include('posts.partials.activity')
    </div>
</div>
@endsection