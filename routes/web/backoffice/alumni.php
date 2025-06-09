<?php

use App\Http\Controllers\Backoffice\Operational\AlumniController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/alumni')->as('backoffice.alumni.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [AlumniController::class, 'index'])->name('index');
        Route::get('table', [AlumniController::class, 'initTable'])->name('table');
        Route::post('store', [AlumniController::class, 'store'])->name('store');
        Route::post('edit/{id}', [AlumniController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AlumniController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('export', [AlumniController::class, 'export_excel'])->name('export');
        Route::get('/alumni/import', [AlumniController::class, 'import'])->name('alumni.import');
        Route::post('/alumni/import_ajax', [AlumniController::class, 'import_ajax'])->name('alumni.import_ajax');
        Route::get('fetch-option', [AlumniController::class, 'fetchOption'])->name('fetch-option');

        Route::get('card-stats', [AlumniController::class, 'cardStats'])->name('card-stats');
    });
