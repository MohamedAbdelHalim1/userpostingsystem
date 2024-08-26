<div>
    <p>{{ $comment->content }} - <small>{{ $comment->user->name }}</small></p>
    @can('delete', $comment)
        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    @endcan
</div>
