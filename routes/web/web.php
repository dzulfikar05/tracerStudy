<?php

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

Route::get('/', function () {
    return view('landingPage.index');
});

// Route::get('login/logout', function () {
    // return view('layouts.index');
// })->name('login/logout');
Route::post('main/getPage', function () {
    return "";
})->name('main/getPage');

Route::get('/landingPage', function () {
    return view('landingPage.index');
});
