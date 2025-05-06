<?php

use App\Http\Controllers\Backoffice\Master\ProfessionCategoryController;
use App\Models\ProfessionCategory;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/master/profession-category')->as('backoffice.master.profession-category.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [ProfessionCategoryController::class, 'index'])->name('index');
        Route::get('fetch-all', [ProfessionCategoryController::class, 'fetchAll'])->name('fetch-all');
        Route::get('table', [ProfessionCategoryController::class, 'initTable'])->name('table');
        Route::get('/export', [ProfessionCategoryController::class, 'export_excel'])->name('export');
        Route::post('store', [ProfessionCategoryController::class, 'store'])->name('store');
        Route::post('edit/{id}', [ProfessionCategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProfessionCategoryController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [ProfessionCategoryController::class, 'destroy'])->name('destroy');
    });

