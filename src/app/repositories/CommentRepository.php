<?php

namespace App\repositories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepository
{
    public function getCommentById(int $commentId): Comment|null;
    public function getCommentsByRecipeId(int $recipeId): Collection;
    public function postComment(Comment $comment): bool;
    public function deleteComment(Comment $comment): bool;
    public function updateComment(Comment $comment, string $newComment): bool;
}

