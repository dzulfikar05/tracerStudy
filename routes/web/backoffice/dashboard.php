<?php

use App\Http\Controllers\Backoffice\Operational\AlumniController;
use App\Http\Controllers\Backoffice\Operational\DashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/dashboard')->as('backoffice.dashboard.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('index');
        Route::post('get-chart-profession', [DashboardController::class, 'getChartProfession'])->name('get-chart-profession');
        Route::post('get-chart-company-type', [DashboardController::class, 'getChartCompanyType'])->name('get-chart-company-type');

    });
