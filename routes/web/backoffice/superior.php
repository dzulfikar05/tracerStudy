<?php

use App\Http\Controllers\Backoffice\Operational\SuperiorsController;
use Illuminate\Support\Facades\Route;

Route::prefix('backoffice/superior')->as('backoffice.superior.')
->middleware('auth')
->group(function () {
    Route::get('', [SuperiorsController::class, 'index'])->name('index');
    Route::get('table', [SuperiorsController::class, 'initTable'])->name('table');
    Route::post('store', [SuperiorsController::class, 'store'])->name('store');
    Route::post('edit/{id}', [SuperiorsController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [SuperiorsController::class, 'update'])->name('update');
    Route::post('destroy/{id}', [SuperiorsController::class, 'destroy'])->name('destroy');

    Route::get('fetch-option', [SuperiorsController::class, 'fetchOptions'])->name('fetch-option');
    Route::get('export-excel', [SuperiorsController::class, 'exportExcel'])->name('export-excel');
    
});