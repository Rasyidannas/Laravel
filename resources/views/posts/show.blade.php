{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', $post->title)

{{-- This will put in @yield('content') --}}
@section('content')
    
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>

    @if(now()->diffInMinutes($post->created_at) < 5)
        <div class="alert alert-info">New!</div>
    @endif

@endsection