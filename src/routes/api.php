<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.keycloak'])->group(function () {
    Route::prefix('categories')->group(base_path('routes/auth/categories.php'));
    Route::prefix('recipes')->group(base_path('routes/auth/comments.php'));
    Route::prefix('recipes')->group(base_path('routes/auth/recipes.php'));
    Route::prefix('users')->group(base_path('routes/auth/users.php'));
    Route::prefix('recipes/categories')->group(base_path('routes/auth/categories.php'));
    Route::prefix('favourites')->group(base_path('routes/auth/favourites.php'));
});
Route::prefix('recipes')->group(base_path('routes/categories.php'));
Route::prefix('recipes')->group(base_path('routes/comments.php'));
Route::prefix('recipes')->group(base_path('routes/recipes.php'));
Route::prefix('users')->group(base_path('routes/users.php'));
Route::prefix('authors')->group(base_path('routes/authors.php'));


