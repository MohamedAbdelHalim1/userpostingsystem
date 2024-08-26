<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{

    protected $user;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_create_comment()
    {
        $token = $this->user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson("/api/posts/{$this->post->id}/comments", [
            'content' => 'This is a test comment.',
            'user_id' => $this->user->id,
        ]);
    
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'content',
                     'post_id',
                     'created_at',
                     'updated_at',
                 ]);
    }
    
    public function test_user_can_view_comments()
    {
        $comment = Comment::create([
            'content' => 'This is a test comment.',
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    
        $token = $this->user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson("/api/posts/{$this->post->id}/comments");
    
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'content' => 'This is a test comment.',
                 ]);
    }
    
    
    public function test_user_can_update_comment()
    {
        $comment = Comment::create([
            'content' => 'Old comment.',
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    
        $token = $this->user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->putJson("/api/posts/{$this->post->id}/comments/{$comment->id}", [
            'content' => 'Updated comment.',
        ]);
    
        $response->assertStatus(200)
                 ->assertJson([
                     'content' => 'Updated comment.',
                 ]);
    }
    
    public function test_user_can_delete_comment()
    {
        $comment = Comment::create([
            'content' => 'This is a test comment.',
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    
        $token = $this->user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->deleteJson("/api/posts/{$this->post->id}/comments/{$comment->id}");
    
        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
    
}
