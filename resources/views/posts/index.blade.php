{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Blog Posts')

{{-- This will put in @yield('content') --}}
@section('content')

<div class="row">  
    <div class="col-8">

        {{-- Conditional with looping --}}
        @forelse ($posts as $key => $post)
            {{-- This is partial template from partials folder --}}
            @include('posts.partials.post', [])
        @empty 
            <p>
                No posts found!
            </p> 
        @endforelse
    </div>

    <div class="col-4">
        @include('posts.partials.activity')
    </div>
</div>

@endsection