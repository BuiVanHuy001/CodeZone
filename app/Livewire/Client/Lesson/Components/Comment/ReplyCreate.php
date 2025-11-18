<?php

namespace App\Livewire\Client\Lesson\Components\Comment;

use App\Models\Comment;
use App\Services\Client\Comment\CommentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReplyCreate extends Component
{
    public Comment $parentComment;
    private commentService $commentService;

    #[Validate('required|string|max:1000')]
    public string $content = '';
    public bool $canSubmit = false;
    public bool $isLastLevel = false;

    public function boot(): void
    {
        $this->commentService = app(CommentService::class);
    }


    public function mount(): void
    {
        $this->content = '@' . $this->parentComment->user->name . ' ';
    }

    public function updatedContent(): void
    {
        $this->canSubmit = $this->content !== '' && strlen($this->content) <= 1000;
        if (strlen($this->content) > 1000) {
            $this->swal(
                title: 'Reply is too long',
                text: 'Reply can\'t be longer than 1,000 characters. Try shortening your comment.',
                icon: 'error',
            );
        }
        if ($this->content === '') {
            $this->swal(
                title: 'Reply is empty',
                text: 'Reply can\'t be empty. Please write something before submitting.',
                icon: 'error',
            );
        }
    }

    public function submitComment(): void
    {
        try {
            $this->validate();
            $this->commentService->storeReplyComment(
                $this->parentComment,
                $this->content,
                $this->isLastLevel
            );
            $this->swal(
                'Success',
                'Your reply has been posted successfully.',
            );
            $this->dispatch('replyAdded', parentId: $this->parentComment->id);
        } catch (AuthorizationException $exception) {
            $this->swalError('Something went wrong. Please try again later.');
        }
    }

    public function render(): View
    {
        return view('livewire.client.lesson.components.comment.reply-create');
    }
}
