<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\CommentService;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;
    protected $commentService;

    public function __construct(PostService $postService, CommentService $commentService)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->middleware('auth'); //Just to Ensure that only authenticated users can access these methods
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $this->postService->createPost([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    public function show($id)
    {
        $post = Post::with('comments.user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        // Show form to edit a post
        $post = Post::findOrFail($id);

        // Ensure the post belongs to the authenticated user
        if ($post->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $this->postService->updatePost($id, [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }
}
