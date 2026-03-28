<?php

namespace App\repositories;

use Illuminate\Database\Eloquent\Collection;

interface CommentRepository
{
    public function getCommentsByRecipeId(int $recipeId): Collection;
    public function postComment(int $recipeId, string $userId, string $commentBody): bool;
    public function deleteComment(int $commentId, string $userId): bool;
    public function updateComment(int $commentId, string $newComment, string $userId): bool;
}

