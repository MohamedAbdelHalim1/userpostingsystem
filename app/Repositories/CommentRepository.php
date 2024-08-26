<?php
namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function create(array $data)
    {
        return $this->comment->create($data);
    }

    public function delete($id)
    {
        return $this->comment->destroy($id);
    }

}
