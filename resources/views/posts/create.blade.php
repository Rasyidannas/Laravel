@extends('layouts.app')

@section('title', 'Create the post')

@section('content')
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf 

        {{-- old('') this is for old value if error or not disaper --}}
        <div><input type="text" name="title" value="{{ old('title') }}"></div>
        {{-- this is for single field error --}}
        @error('title')
            <div>{{ $message }}</div>
        @enderror

        <div><textarea name="content">{{ old('content') }}</textarea></div>
        {{-- this is for all fields error --}}
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div><input type="submit"></div>
    </form>
@endsection