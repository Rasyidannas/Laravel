{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Blog Posts')

{{-- This will put in @yield('content') --}}
@section('content')

{{-- Conditional with looping --}}
    @forelse ($posts as $key => $post)
    {{-- This is partial template from partials folder --}}
       @include('posts.partials.post', [])
    @empty 
        No posts found!
    @endforelse

@endsection