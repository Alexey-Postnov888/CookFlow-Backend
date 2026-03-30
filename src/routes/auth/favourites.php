<?php

use App\Http\Controllers\FavouriteController;
use Illuminate\Support\Facades\Route;

Route::post('/favourites/{recipeId}', [FavouriteController::class, 'createFavourite']);

Route::delete('/favourites/{recipeId}', [FavouriteController::class, 'deleteFavourite']);

