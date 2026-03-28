<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::post('/{recipeId}/comments', [CommentController::class, 'postComment']);

Route::delete('/comments/{commentId}', [CommentController::class, 'deleteComment']);

Route::put('/comments/{commentId}', [CommentController::class, 'updateComment']);
