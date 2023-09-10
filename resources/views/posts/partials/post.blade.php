{{-- @break($key == 2) --}}
{{-- @continue($key == 1) --}}

{{-- {{ dd($post->trashed()) }} --}}

<h3>
    @if ($post->trashed())
        <del>
    @endif
    
    <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
    href="{{ route('posts.show', ['post' => $post-> id]) }}">{{ $key }}. {{ $post->title }}</a>
    
    @if ($post->trashed())
        </del>
    @endif
</h3>
    {{-- this is using component  --}}
    <x-updated :date="$post->created_at" :name="$post->user->name" :userId="$post->user->id" />

    <x-tags :tags="$post->tags" />

@if($post->comments_count)
    <p>{{ $post->comments_count }} comments </p>
@else
    <p>No comments yet!</p>
@endif

<div class="mb-3">
    {{-- @auth is more effective in optimize because it will only when user is authentication --}}
    {{-- @can is connect with authorization --}}
    @auth
        @can('update', $post)
            <a href="{{ route('posts.edit', ['post' => $post-> id]) }}" class="btn btn-primary">Edit</a>
        @endcan
    @endauth

    {{-- @cannot('delete', $post)
        <p>You can delete this post</p>
    @endcannot --}}
    @auth
        @if (!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Deleted!" class="btn btn-danger">
                </form>
            @endcan
        @endif
    @endauth
</div>