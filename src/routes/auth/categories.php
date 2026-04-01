<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/', [CategoryController::class, 'postCategory']);

Route::delete('/{categoryId}', [CategoryController::class, 'deleteCategory']);

Route::put('/{categoryId}', [CategoryController::class, 'updateCategory']);

