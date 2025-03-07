<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->middleware('guest')->group(function() {
    Route::get('auth/login','index')->name('auth.login');
});
Route::controller(AuthController::class)->group(function() {
    // Route::get('/login','index')->name('login');
    Route::post('auth/login/authentication','authentication')->name('auth.login.authentication');
    Route::get('auth/logout', 'logout')->name(('auth.logout'));
});
