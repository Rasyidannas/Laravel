{{-- @break($key == 2) --}}
{{-- @continue($key == 1) --}}
<h3><a href="{{ route('posts.show', ['post' => $post-> id]) }}">{{ $key }}. {{ $post->title }}</a></h3>

<div class="mb-3">
    <a href="{{ route('posts.edit', ['post' => $post-> id]) }}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Deleted!" class="btn btn-danger">
    </form>
</div>