<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\repositories\CommentRepository;


class CommentController extends Controller
{

    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository) {
        $this->commentRepository = $commentRepository;
    }

    public function getCommentsByRecipeId(int $recipeId)
    {
        $comments = $this->commentRepository->getCommentsByRecipeId($recipeId);
        return $comments;
    }

    public function postComment(Request $request, int $recipeId): bool {
        $isSuccess = $this->commentRepository->postComment($recipeId, $request->sub(), $request['comment']);
        return $isSuccess;
    }

    public function deleteComment(Request $request, int $commentId): bool {
        return $this->commentRepository->deleteComment($commentId, $request->sub());
    }

    public function updateComment(Request $request, int $commentId): bool {
        return $this->commentRepository->updateComment($commentId, $request['comment'], $request->sub());
    }
}
