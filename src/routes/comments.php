<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/{recipeId}/comments', [CommentController::class, 'getCommentsByRecipeId']);
