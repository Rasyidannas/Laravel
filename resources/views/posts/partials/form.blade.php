{{-- old('') this is for old value if error or not disaper --}}
<div><input type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}"></div>
{{-- this is for single field error --}}
@error('title')
    <div>{{ $message }}</div>
@enderror

<div><textarea name="content">{{ old('content', optional($post ?? null)->content) }}</textarea></div>
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