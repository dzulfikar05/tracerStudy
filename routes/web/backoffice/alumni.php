<?php

use App\Http\Controllers\Backoffice\Master\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/alumni')->as('backoffice.alumni.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('table', [UserController::class, 'initTable'])->name('table');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::post('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
