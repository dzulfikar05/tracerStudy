<?php

use App\Http\Controllers\Backoffice\Operational\ContentController;
use App\Http\Controllers\Backoffice\Operational\AlumniController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/content')->as('backoffice.content.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [ContentController::class, 'index'])->name('index');
        Route::get('table', [ContentController::class, 'initTable'])->name('table');
        Route::post('store', [ContentController::class, 'store'])->name('store');
        Route::post('edit/{id}', [ContentController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ContentController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [ContentController::class, 'destroy'])->name('destroy');
        Route::post('up-order/{id}', [ContentController::class, 'upOrder'])->name('up-order');
        Route::post('down-order/{id}', [ContentController::class, 'downOrder'])->name('down-order');
    });
