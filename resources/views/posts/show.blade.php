{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', $post['title'])

{{-- This will put in @yield('content') --}}
@section('content')

{{-- Conditional --}}
    {{-- This is conditional render for $post['is_new'] --}}
    @if($post['is_new'])
        <div> A new blog post! using if </div>
        @else(!$post['is_new'])
        <div> Blog post is old! using else </div>
    @endif

    {{-- this will be execute when false --}}
    @unless ($post['is_new'])
        <div> It is an old post... using unless </div>
    @endunless
    
    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['content'] }}</p>

    {{-- This will be execute when true --}}
    @isset($post['has_comments'])
        <div> The post has some comments... using isset </div>
    @endisset
@endsection