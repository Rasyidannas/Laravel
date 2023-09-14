{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', $post->title)

{{-- This will put in @yield('content') --}}
@section('content')
<div class="row">  
    <div class="col-8">
        @if ($post->image)
            <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align:center; background-attachment: fixed;">
                {{-- <img src="{{ Storage::url($post->image->path) }}"/> --}}
                {{-- this is form Image Model using function url() --}}
                {{-- <img src="{{ $post->image->url() }}"/> --}}
                <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else
            <h1>
        @endif
            {{ $post->title }}
            {{-- This is usig component --}}
            <x-badge :show="now()->diffInMinutes($post->created_at) < 5">
                Brand new post!
            </x-badge>

        @if ($post->image)
                </h1>
            </div>
        @else
                </h1>
        @endif

        <p>{{ $post->content }}</p>
        {{-- this is using component  --}}
        <x-updated :date="$post->created_at" :name="$post->user->name" />
        <x-updated :date="$post->updated_at" :name="$post->user->name">Updated</x-updated>

        <x-tags :tags="$post->tags" />

        <p>Currently read by {{ $counter }} people</p>

        <h1>Comments</h1>

        <x-commentForm :route="route('posts.comments.store', ['post' => $post->id])" />

        <x-commentList :comments="$post->comments" />
    </div>
    <div class="col-4">
        @include('posts.partials.activity')
    </div>
</div>
@endsection