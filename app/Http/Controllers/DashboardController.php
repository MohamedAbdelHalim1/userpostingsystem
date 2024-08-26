<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->middleware('auth'); 
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('dashboard', compact('posts'));
    }
}
