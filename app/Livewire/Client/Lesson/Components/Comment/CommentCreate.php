<?php

namespace App\Livewire\Client\Lesson\Components\Comment;

use App\Models\Lesson;
use App\Services\Client\Comment\CommentService;
use App\Traits\WithSwal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CommentCreate extends Component
{
    use WithSwal;
    public Lesson $lesson;
    private CommentService $commentService;
    public bool $canSubmit = false;

    #[Validate('required|string|max:1000')]
    public string $content = '';

    public function boot(): void
    {
        $this->commentService = app(CommentService::class);
    }

    public function updatedContent(): void
    {
        $this->canSubmit = $this->content !== '' && strlen($this->content) <= 1000;
        if (strlen($this->content) > 1000) {
            $this->swal(
                title: 'Comment is too long',
                text: 'Comments can\'t be longer than 1,000 characters. Try shortening your comment.',
                icon: 'error',
            );
        }
        if ($this->content === '') {
            $this->swal(
                title: 'Comment is empty',
                text: 'Comments can\'t be empty. Please write something before submitting.',
                icon: 'error',
            );
        }
    }

    public function submitComment(): void
    {
        try {
            $this->validate();
            $this->commentService->storeComment($this->lesson, $this->content);
            $this->reset('content');
            $this->swal(
                'Success',
                'Your comment has been posted successfully.',
            );
            $this->dispatch('commentAdded');
        } catch (AuthorizationException $exception) {
            $this->swalError($exception->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.client.lesson.components.comment.comment-create');
    }
}
