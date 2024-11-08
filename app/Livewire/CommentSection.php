<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentSection extends Component
{
    public $post;
    public $newComment;

    protected $rules = [
        'newComment' => 'required|min:3',
    ];

    public function mount($post)
    {
        $this->post = $post;
    }

    public function addComment()
    {
        $this->validate();

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $this->newComment,
        ]);

        $this->newComment = '';
        $this->post = $this->post->fresh(['comments.user']);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);

        if ($comment->user_id === auth()->id()) {
            $comment->delete();
            $this->post = $this->post->fresh(['comments.user']);
        }
    }
    public function render()
    {
        return view('livewire.comment-section');
    }
}
