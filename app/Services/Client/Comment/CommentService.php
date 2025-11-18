<?php

namespace App\Services\Client\Comment;

use App\Models\Comment;
use Illuminate\Support\Collection;

readonly class CommentService
{
    public function __construct(
        public CommentManagementService $commentManagementService,
        public CommentDisplayService    $commentDisplayService,
    )
    {
    }

    public function getComments($commentable): Collection
    {
        return $this->commentDisplayService->getComments($commentable);
    }

    public function getReplies(Comment $comment): Collection
    {
        return $this->commentDisplayService->getReplies($comment);
    }

    public function storeComment($commentable, string $content): ?Comment
    {
        return $this->commentManagementService->storeComment($commentable, $content);
    }

    public function storeReplyComment(Comment $parent, string $content, bool $isLastLevel): ?Comment
    {
        return $this->commentManagementService->storeReplyComment($parent, $content, $isLastLevel);
    }

    public function deleteComment(string $commentId): bool
    {
        return $this->commentManagementService->destroyComment($commentId);
    }
}
