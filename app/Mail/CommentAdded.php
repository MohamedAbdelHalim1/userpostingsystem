<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;
use App\Models\Post;

class CommentAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $post;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Comment Added to Your Post',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.comment_added', // Replace with your actual view path
            with: [
                'comment' => $this->comment,
                'post' => $this->post,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}