@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('register') }}">
     @csrf

     <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
     </div>

     <div class="form-group">
        <label>E-mail</label>
        <input type="text" name="email" value="{{ old('email') }}" required class="form-control">
     </div>

     <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" required class="form-control">
     </div>

     <div class="form-group">
        <label>Retyped Password</label>
        <input type="text" name="password_confirmation" required class="form-control">
     </div>

     <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection