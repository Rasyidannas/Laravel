{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact page')

{{-- This will put in @yield('content') --}}
@section('content')
    <h1>Contact</h1>
    <p>Hello this is contact!</p>

    @can('home.secret')
        <p>
            <a href="{{ route('home.secret') }}">
                Special contact details
            </a>
        </p>
    @endcan
@endsection