<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\repositories\CommentRepository;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;


class CommentController extends Controller
{

    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository) {
        $this->commentRepository = $commentRepository;
    }

    public function getCommentById(int $commentId): JsonResponse
    {
        try
        {
            $comment = $this->commentRepository->getCommentById($commentId);

            if (is_null($comment))
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not found'
                ], Response::HTTP_NOT_FOUND);
            }
            else
            {
                return response()->json([
                    'success' => true,
                    'comment' => $comment
                ], Response::HTTP_OK);
            }
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getCommentsByRecipeId(int $recipeId): JsonResponse
    {
        try
        {
            $comments = $this->commentRepository->getCommentsByRecipeId($recipeId);
            return response()->json([
                'success' => true,
                'comments' => $comments
            ], Response::HTTP_OK);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function postComment(Request $request, int $recipeId): JsonResponse
    {
        try
        {
            $validated = $request->validate([
                'comment' => 'required|string'
            ]);

            $validated['recipe_id'] = $recipeId;
            $validated['user_id'] = $request->sub();

            $comment = (new Comment())->fill($validated);
            $isSuccess = $this->commentRepository->postComment($comment);

            if ($isSuccess) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment added'
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not added'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteComment(Request $request, int $commentId): JsonResponse
    {
        try
        {
            $comment = $this->commentRepository->getCommentById($commentId);

            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not found'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($comment['user_id'] != $request->sub()) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permission to delete this comment"
                ], Response::HTTP_FORBIDDEN);
            }

            $isSuccess = $this->commentRepository->deleteComment($comment);
            if ($isSuccess)
            {
                return response()->json([
                    'success' => true,
                    'message' => "Deleted comment ".$commentId." successfully"
                ], Response::HTTP_OK);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not deleted'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateComment(Request $request, int $commentId) {
        try
        {
            $validated = $request->validate([
                'comment' => 'required|string'
            ]);

            $comment = $this->commentRepository->getCommentById($commentId);

            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not found'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($comment['user_id'] != $request->sub()) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permission to update this comment"
                ], Response::HTTP_FORBIDDEN);
            }

            $isSuccess = $this->commentRepository->updateComment($comment, $validated['comment']);
            if ($isSuccess) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment updated'
                ], Response::HTTP_OK);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not updated'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
