{{-- old('') this is for old value if error or not disaper --}}
<div class="form-group">
    <label for="title">Title</label>
    <input id="title" class="from-control" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
{{-- this is for single field error --}}
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" class="form-control" name="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>
{{-- this is for all fields error --}}
@if ($errors->any())
    <div class="mb-3">
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif