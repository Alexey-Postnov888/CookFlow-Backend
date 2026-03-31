<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecipeController::class, 'getRecipes']);
Route::get('/{id}', [RecipeController::class, 'getRecipeById']);
Route::get('/categories/{category_id}', [RecipeController::class, 'getRecipesByCategory']);
