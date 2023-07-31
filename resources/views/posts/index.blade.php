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
        <div class="contaier">
            {{-- This for most commented --}}
            <div class="row">
                <div class="card" style="width: 100%">
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
            {{-- User Active --}}
            <div class="row mt-4">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Active</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Users with most posts written</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{-- User Active in last month--}}
            <div class="row mt-4">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Last Month</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Users with most posts written in the last month</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection