<?php

namespace App\View\Components\Client\Comment;

use App\Models\Comment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommentItem extends Component
{
    public function __construct(
        public Comment $comment,
        public ?int    $replyingTo
    )
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.client.comment.comment-item');
    }
}
