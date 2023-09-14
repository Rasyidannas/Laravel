@forelse($comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    
    <p class="text-muted">
        {{-- this is using component  --}}
        <x-updated :date="$comment->created_at" :name="$comment->user->name" :userId="$comment->user->id" />
    </p>
@empty 
    <p>No comments yet!</p>
@endforelse