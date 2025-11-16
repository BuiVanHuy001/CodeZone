<?php

namespace App\Livewire\Client\Lesson\Components\Comment;

use App\Models\Comment;
use App\Models\Lesson;
use App\Services\Client\Comment\CommentService;
use App\Traits\HasNumberFormat;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentArea extends Component
{
    use HasNumberFormat;

    public Lesson $lesson;
    private CommentService $commentService;
    public Collection $comments;
    public string $commentCountText;
    public ?int $replyingTo = null;
    public array $loadedReplies = [];

    public function boot(): void
    {
        $this->commentService = app(CommentService::class);
    }

    public function mount(): void
    {
        $this->refreshComments();
        $this->loadedReplies = $this->comments->pluck('id')->mapWithKeys(fn($id) => [$id => []])->toArray();
    }

    #[On('commentAdded')]
    public function refreshComments(): void
    {
        $this->comments = $this->commentService->getComments($this->lesson);
        $this->commentCountText = $this->formatCount($this->comments->count(), 'comment');
    }

    #[On('replyAdded')]
    public function refreshReplies(int $parentId): void
    {
        $comment = Comment::find($parentId);
        if (!$comment) return;

        $this->loadedReplies = array_merge($this->loadedReplies, [
            $parentId => $this->commentService->getReplies($comment),
        ]);

        $this->replyingTo = null;
    }

    public function loadReplies(int $commentId): void
    {
        $comment = Comment::with('commentable')
            ->with('user')
            ->find($commentId);

        if (!$comment) return;

        $replies = $this->commentService->getReplies($comment);

        $this->loadedReplies[$commentId] = $replies;

        foreach ($replies as $reply) {
            $this->loadedReplies[$reply->id] = $this->loadedReplies[$reply->id] ?? [];
        }
    }

    public function showReplyForm(int $commentId): void
    {
        $this->replyingTo = $commentId;
    }

    public function deleteComment(string $commentId): void
    {
        $this->swalConfirm(
            method: 'destroyComment',
            componentId: $this->getId(),
            parameters: [$commentId],
            text: 'This action cannot be undone.');
    }

    public function destroyComment(string $commentId): void
    {
        try {
            if ($this->commentService->deleteComment($commentId)) {
                $this->refreshComments();
                $this->swal('Deleted!', 'The comment has been deleted.');
            } else {
                $this->swalError('The comment could not be deleted.', 'Please try again later.');
            }
        } catch (\Exception $exception) {
            $this->swalError($exception->getMessage(), 'Please try again.');
        }
    }

    public function render(): View
    {
        return view('livewire.client.lesson.components.comment-area');
    }
}
