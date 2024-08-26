<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @api {get} /api/posts/:post_id/comments Get all comments for a post
     * @apiName GetComments
     * @apiGroup Comments
     *
     * @apiParam {Number} post_id Post's unique ID.
     *
     * @apiSuccess {Object[]} comments List of comments.
     */
    public function index(Post $post)
    {
        return $post->comments;
    }

    /**
     * @api {post} /api/posts/:post_id/comments Create a new comment
     * @apiName CreateComment
     * @apiGroup Comments
     *
     * @apiParam {Number} post_id Post's unique ID.
     * @apiBody {String} content Comment content.
     *
     * @apiSuccess {Object} comment Newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        return $comment;
    }

    /**
     * @api {get} /api/posts/:post_id/comments/:comment_id Get a specific comment
     * @apiName GetComment
     * @apiGroup Comments
     *
     * @apiParam {Number} post_id Post's unique ID.
     * @apiParam {Number} comment_id Comment's unique ID.
     *
     * @apiSuccess {Object} comment Comment details.
     */
    public function show(Post $post, Comment $comment)
    {
        return $comment;
    }

    /**
     * @api {put} /api/posts/:post_id/comments/:comment_id Update a specific comment
     * @apiName UpdateComment
     * @apiGroup Comments
     *
     * @apiParam {Number} post_id Post's unique ID.
     * @apiParam {Number} comment_id Comment's unique ID.
     * @apiBody {String} content Comment content (optional).
     *
     * @apiSuccess {Object} comment Updated comment details.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $request->validate([
            'content' => 'string',
        ]);

        $comment->update($request->all());

        return $comment;
    }

    /**
     * @api {delete} /api/posts/:post_id/comments/:comment_id Delete a specific comment
     * @apiName DeleteComment
     * @apiGroup Comments
     *
     * @apiParam {Number} post_id Post's unique ID.
     * @apiParam {Number} comment_id Comment's unique ID.
     *
     * @apiSuccess {String} message Success message.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $comment->delete();

        return response()->noContent();
    }
}
