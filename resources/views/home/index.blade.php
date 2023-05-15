{{-- This is call layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Home page')

{{-- This will put in @yield('content') --}}
@section('content')
    <h1>Hello World</h1>
@endsection