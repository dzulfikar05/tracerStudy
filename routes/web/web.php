<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/list-survey', [HomeController::class, 'listSurveyIndex'])->name('list-survey');
Route::get('/about', [HomeController::class, 'aboutIndex'])->name('about');


// Route::get('login/logout', function () {
// return view('layouts.index');
// })->name('login/logout');

Route::get('/landingPage', function () {
    return view('landingPage.index');
});