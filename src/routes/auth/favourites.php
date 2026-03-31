<?php

use App\Http\Controllers\FavouriteController;
use Illuminate\Support\Facades\Route;

Route::post('/{recipeId}', [FavouriteController::class, 'createFavourite']);

Route::delete('/{recipeId}', [FavouriteController::class, 'deleteFavourite']);

