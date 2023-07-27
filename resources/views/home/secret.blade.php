{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact page')

{{-- This will put in @yield('content') --}}
@section('content')
    <h1>Secret Page</h1>
    <p>Hello this is secret email secret@laravel test!</p>
@endsection