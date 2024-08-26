<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ]);
    
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'title',
                     'content',
                     'created_at',
                     'updated_at',
                 ]);
    
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'user_id' => $user->id, 
        ]);
    }
    
    
    public function test_user_can_view_posts()
    {
        $user = User::factory()->create();
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'user_id' => $user->id,
        ]);
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson("/api/posts/{$post->id}");
    
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'title' => 'Test Post',
                     'content' => 'This is a test post.',
                 ]);
    }
    
    
    public function test_user_can_update_post()
    {
        $post = Post::create([
            'title' => 'Old Title',
            'content' => 'Old content.',
            'user_id' => $this->user->id,
        ]);
    
        $token = $this->user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    
        $response->assertStatus(200)
                 ->assertJson([
                     'title' => 'Updated Title',
                     'content' => 'Updated content.',
                 ]);
    }
    
    public function test_user_can_delete_post()
    {
        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'user_id' => $this->user->id,
        ]);
    
        $token = $this->user->createToken('auth_token')->plainTextToken;
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->deleteJson("/api/posts/{$post->id}");
    
        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
    
}
