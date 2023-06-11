{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Home page')

{{-- This will put in @yield('content') --}}
@section('content')
    <h1>Welcome to Laravel!</h1>
    <p>This is the content of the main page!</p>
@endsection