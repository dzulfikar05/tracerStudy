<?php

use App\Http\Controllers\Backoffice\Master\CompanyController;
use App\Http\Controllers\Backoffice\Operational\AnswerController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/answer')->as('backoffice.answer.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [AnswerController::class, 'index'])->name('index');
        Route::get('fetch-all', [AnswerController::class, 'fetchAll'])->name('fetch-all');
        Route::get('table', [AnswerController::class, 'initTable'])->name('table');
        Route::post('store', [AnswerController::class, 'store'])->name('store');
        Route::post('edit/{id}', [AnswerController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AnswerController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [AnswerController::class, 'destroy'])->name('destroy');
    });
