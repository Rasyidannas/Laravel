<p>
    @foreach ($tags as $tag)
        <a href="#" class="badge bg-success badge-lg">{{ $tag->name }}</a>
    @endforeach
</p>