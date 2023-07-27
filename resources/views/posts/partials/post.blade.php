{{-- @break($key == 2) --}}
{{-- @continue($key == 1) --}}
<h3><a href="{{ route('posts.show', ['post' => $post-> id]) }}">{{ $key }}. {{ $post->title }}</a></h3>

<p class="text-muted">
    Added {{ $post->created_at->diffForHumans() }}
    by {{ $post->user->name }}
</p>

@if($post->comments_count)
    <p>{{ $post->comments_count }} comments </p>
@else
    <p>No comments yet!</p>
@endif

<div class="mb-3">
    {{-- @can is connect with authorization --}}
    @can('update', $post)
        <a href="{{ route('posts.edit', ['post' => $post-> id]) }}" class="btn btn-primary">Edit</a>
    @endcan

    {{-- @cannot('delete', $post)
        <p>You can delete this post</p>
    @endcannot --}}

    @can('delete', $post)
        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Deleted!" class="btn btn-danger">
        </form>
    @endcan
</div>