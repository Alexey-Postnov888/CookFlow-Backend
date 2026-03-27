<?php

namespace App\repositories\impl;;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use App\repositories\CommentRepository;

class CommentRepositoryImpl implements CommentRepository {

    public function getCommentsByRecipeId(int $recipeId): Collection
    {
        return Comment::where("recipe_id", $recipeId)->get();
    }

    public function postComment(int $recipeId, string $userId, string $commentBody): bool
    {
        $comment = new Comment();
        $comment->recipe_id = $recipeId;
        $comment->user_id = $userId;
        $comment->comment = $commentBody;

        return $comment->save();
    }

    public function deleteComment(int $commentId, string $userId): bool
    {
        $comment = Comment::where("user_id", $userId)
            ->where("id", $commentId)
            ->first();

        if ($comment) {
            return $comment->delete();
        }
        else {
            return false;
        }
    }

    public function updateComment(int $commentId, string $newComment, string $userId): bool
    {
        $comment = Comment::where("user_id", $userId)
            ->where("id", $commentId)
            ->first();

        if ($comment) {
            $comment->comment = $newComment;
            return $comment->save();
        }
        else {
            return false;
        }
    }
}
