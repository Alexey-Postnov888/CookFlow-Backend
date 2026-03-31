<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/{userId}/change-role', [UserController::class, 'changeRole']);
