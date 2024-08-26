<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->post->latest()->get();
    }
    
    public function create(array $data)
    {
        return $this->post->create($data);
    }

    public function update($id, array $data)
    {
        $post = $this->post->find($id);
        return $post->update($data);
    }

    public function delete($id)
    {
        return $this->post->destroy($id);
    }

}
