<x-mail::message>
# Comment was posted on you were watching

Hi {{ $user->name }}

<x-mail::button :url="route('posts.show', ['post' => $comment->commentable->id])">
View The Blog Post
</x-mail::button>

<x-mail::button :url="route('users.show', ['user' => $comment->user->id])">
Visit {{ $comment->user->name }} profile
</x-mail::button>

<x-mail::panel>
    {{ $comment->content }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
