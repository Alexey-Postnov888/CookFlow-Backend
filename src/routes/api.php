<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.keycloak'])->group(function () {
    Route::prefix('categories')->group(base_path('routes/auth/categories.php'));
    Route::prefix('recipes')->group(base_path('routes/auth/comments.php'));
    Route::prefix('users')->group(base_path('routes/auth/users.php'));
});

Route::prefix('recipes')->group(base_path('routes/comments.php'));
Route::prefix('users')->group(base_path('routes/users.php'));
