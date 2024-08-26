<!DOCTYPE html>
<html>
<head>
    <title>New Comment Added</title>
</head>
<body>
    <h1>New Comment on Your Post: {{ $post->title }}</h1>
    <p>{{ $comment->content }}</p>
    <p>Commented by: {{ $comment->user->name }}</p>
    <p><a href="{{ route('posts.show', $post->id) }}">View Post</a></p>
</body>
</html>
