<?php

use App\Http\Controllers\Backoffice\Master\JobCategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/master/job-category')->as('backoffice.master.job-category.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [JobCategoryController::class, 'index'])->name('index');
        Route::get('table', [JobCategoryController::class, 'initTable'])->name('table');
        Route::post('store', [JobCategoryController::class, 'store'])->name('store');
        Route::post('edit', [JobCategoryController::class, 'edit'])->name('edit');
        Route::post('update', [JobCategoryController::class, 'update'])->name('update');
        Route::post('destroy', [JobCategoryController::class, 'destroy'])->name('destroy');
    });
