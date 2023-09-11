@extends('layouts.app')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('users.update', ['user' => $user->id]) }}" class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" class="img-thumbnail avatar" />
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload different photo</h6>
                        <input class="form-control-file" type="file" name="avatar" />
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="">Name:</label>
                    <input class="form-control" value="" type="text" name="name" />
                </div>

                <x-errors />

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Save Changes">
                </div>
            </div>
        </div>
    </form>
@endsection