<?php

use App\Http\Controllers\Backoffice\Master\ProfessionController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/master/profession')->as('backoffice.master.profession.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [ProfessionController::class, 'index'])->name('index');
        Route::get('table', [ProfessionController::class, 'initTable'])->name('table');
        Route::post('store', [ProfessionController::class, 'store'])->name('store');
        Route::get('/export', [ProfessionController::class, 'export_excel'])->name('export');
        Route::post('edit/{id}', [ProfessionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProfessionController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [ProfessionController::class, 'destroy'])->name('destroy');
    });
