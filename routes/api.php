<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Auth\AuthController::class)->group( function () {
    Route::prefix('user')->group( function () {
       Route::post('register', 'register');
       Route::post('login', 'login');
    });
});
