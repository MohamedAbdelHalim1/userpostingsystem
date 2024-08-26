<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Mail\CommentAdded;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('auth');
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($postId);

        $comment = $this->commentService->addComment([
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        Mail::to($post->user->email)->send(new CommentAdded($comment, $post));

        return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }
        $this->commentService->deleteComment($id);

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
