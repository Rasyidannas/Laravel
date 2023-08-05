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
                {{-- this is using component --}}
                <x-card title="Most Commented">
                    <x-slot:subtitle>What people currently talking about</x-slot>
                    @slot('items')
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    @endslot
                </x-card>
            </div>
                {{-- User Active --}}
                {{-- this is using component --}}
                <x-card title="Most Active">
                    <x-slot:subtitle>Users with most posts written</x-slot>
                    @slot('items', collect($mostActive)->pluck('name'))
                </x-card>
            </div>
            <div class="row mt-4">
                {{-- User Active in last month--}}
                {{-- this is using component --}}
                <x-card title="Most Active Last Month">
                    <x-slot:subtitle>Users with most posts written in the last month</x-slot>
                    @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                </x-card>
            </div>
        </div>
    </div>
</div>

@endsection