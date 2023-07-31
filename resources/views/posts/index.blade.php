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
        <div class="card" style="width: 18rem">
            <div class="card-body">
                <h5 class="card-title">Most Commented</h5>
                <h6 class="card-subtitle mb-2 text-muted">What people currently talking about</h6>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection