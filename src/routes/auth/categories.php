<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $userId = $request->sub();
    $role = 'author';
    $hasRole = $request->hasRole($role);
    if ($hasRole) {
        return 'Ты '.$role;
    } else {
        return 'Ты не '.$role;
    }
});
