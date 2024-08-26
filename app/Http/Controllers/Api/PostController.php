<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
     /**
     * @api {get} /api/posts Get all posts
     * @apiName GetPosts
     * @apiGroup Posts
     *
     * @apiSuccess {Object[]} posts List of posts.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * @api {post} /api/posts Create a new post
     * @apiName CreatePost
     * @apiGroup Posts
     *
     * @apiBody {String} title Post title.
     * @apiBody {String} content Post content.
     *
     * @apiSuccess {Object} post Newly created post.
     */

     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string',
             'content' => 'required|string',
         ]);
     
         $post = Post::create([
             'title' => $request->input('title'),
             'content' => $request->input('content'),
             'user_id' => $request->user()->id, 
         ]);
     
         return response()->json($post, 201);
     }
     

    /**
    * @api {get} /api/posts/:id Get a specific post
    * @apiName GetPost
    * @apiGroup Posts
    *
    * @apiParam {Number} id Post's unique ID.
    *
    * @apiSuccess {Object} post Post details.
    */

    public function show(Post $post)
    {
        return $post;
    }

    /**
     * @api {put} /api/posts/:id Update a specific post
     * @apiName UpdatePost
     * @apiGroup Posts
     *
     * @apiParam {Number} id Post's unique ID.
     * @apiBody {String} title Post title (optional).
     * @apiBody {String} content Post content (optional).
     *
     * @apiSuccess {Object} post Updated post details.
     */

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'string',
            'content' => 'string',
        ]);

        $post->update($request->all());

        return $post;
    }

     /**
     * @api {delete} /api/posts/:id Delete a specific post
     * @apiName DeletePost
     * @apiGroup Posts
     *
     * @apiParam {Number} id Post's unique ID.
     *
     * @apiSuccess {String} message Success message.
     */

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
