<?php

namespace App\repositories\impl;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use App\repositories\CommentRepository;

class CommentRepositoryImpl implements CommentRepository {

    public function getCommentById(int $commentId): Comment|null
    {
        return Comment::find($commentId);
    }

    public function getCommentsByRecipeId(int $recipeId): Collection
    {
        return Comment::where("recipe_id", $recipeId)->get();
    }

    public function postComment(Comment $comment): bool
    {
        return $comment->save();
    }

    public function deleteComment(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function updateComment(Comment $comment, string $newComment): bool
    {
        $comment['comment'] = $newComment;
        return $comment->save();
    }
}
