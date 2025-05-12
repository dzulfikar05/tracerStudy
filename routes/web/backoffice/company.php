<?php

use App\Http\Controllers\Backoffice\Master\CompanyController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/master/company')->as('backoffice.master.company.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [CompanyController::class, 'index'])->name('index');
        Route::get('fetch-all', [CompanyController::class, 'fetchAll'])->name('fetch-all');
        Route::get('table', [CompanyController::class, 'initTable'])->name('table');
        Route::post('store', [CompanyController::class, 'store'])->name('store');
        Route::post('edit/{id}', [CompanyController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CompanyController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [CompanyController::class, 'destroy'])->name('destroy');
        Route::get('/export', [CompanyController::class, 'export_excel'])->name('export');
    });
