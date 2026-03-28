<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::post('/', [RecipeController::class, 'postRecipe']);
Route::put('/{id}', [RecipeController::class, 'updateRecipeById']);
Route::delete('/{id}', [RecipeController::class, 'deleteRecipeById']);
Route::get('/authors/{author_id}', [RecipeController::class, 'getRecipeByAuthor']);
Route::get('/favourites', [RecipeController::class, 'getFavourites']);
