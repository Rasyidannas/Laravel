@extends('layouts.app')

@section('title', 'Update the post')

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id])}}" method="POST" enctype="multipart/form-data">
        @csrf 
        {{-- this is http method and we set with put because update form --}}
        @method('PUT')
        @include('posts.partials.form')
        <div><input type="submit" value="Update" class="btn btn-primary btn-block"></div>
    </form>
@endsection