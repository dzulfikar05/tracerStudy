<?php

use App\Http\Controllers\Backoffice\Operational\AlumniController;
use App\Http\Controllers\Backoffice\Operational\DashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/dashboard')->as('backoffice.dashboard.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('index');

    });
