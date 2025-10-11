<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Models\CommentMention;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class CommentManagementService
{
    use AuthorizesRequests;

    public function storeComment($commentable, string $content): ?Comment
    {
        $this->authorize('create', Comment::class);

        return $commentable->comments()->create([
            'content' => $content,
            'user_id' => auth()->id(),
        ]);
    }

    public function storeReplyComment(Comment $parent, string $content, bool $isLastLevel): ?Comment
    {
        DB::beginTransaction();

        try {
            $this->authorize('create', Comment::class);

            if (!$parent->exists) {
                throw new \InvalidArgumentException('Parent comment does not exist.');
            }

            $commentable = $isLastLevel
                ? $parent->commentable
                : $parent;

            $comment = Comment::create([
                'content' => $content,
                'user_id' => auth()->id(),
                'commentable_id' => $commentable->id,
                'commentable_type' => get_class($commentable),
            ]);

            CommentMention::create([
                'comment_id' => $comment->id,
                'user_id' => $parent->user_id,
            ]);

            DB::commit();

            return $comment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroyComment(string $commentId): ?bool
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            return false;
        }

        $this->authorize('delete', $comment);
        return $comment->delete();
    }

    public function updateComment()
    {
        // Not implemented yet
    }
}
