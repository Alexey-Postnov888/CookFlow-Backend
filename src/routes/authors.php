<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'getAuthors']);

Route::get('/{author_id}', [UserController::class, 'getAuthorById']);
