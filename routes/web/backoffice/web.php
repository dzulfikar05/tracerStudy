<?php

use Illuminate\Support\Facades\Route;

Route::get('/backoffice', function () {
    return view('layouts.index');
})
->middleware('auth')
->name('backoffice');
