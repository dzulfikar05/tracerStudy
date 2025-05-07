<?php

use App\Http\Controllers\Backoffice\Master\CompanyController;
use App\Http\Controllers\Backoffice\Operational\AlumniController;
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
Route::get('/list-questionnaire', [HomeController::class, 'listQuestionnaireIndex'])->name('list-questionnaire');
Route::get('/about', [HomeController::class, 'aboutIndex'])->name('about');

Route::get('/questionnaire/{id}', [HomeController::class, 'showQuestionnaireById'])->name('questionnaire.show');

Route::get('/fetch-option', [HomeController::class, 'fetchOption'])->name('fetch-option');
Route::get('/fetch-alumni', [HomeController::class, 'fetchAlumni'])->name('fetch-alumni');

Route::post('/validate-alumni', [HomeController::class, 'validateAlumni'])->name('validate-alumni');
Route::post('/validate-superior', [HomeController::class, 'validateSuperior'])->name('validate-superior');
Route::get('/questionnaire/{id}/content', [HomeController::class, 'contentQuestionnaire'])->name('questionnaire.content');
Route::post('/questionnaire/store-alumni', [HomeController::class, 'storeAlumni'])->name('questionnaire.store-alumni');
Route::post('/questionnaire/store-superior', [HomeController::class, 'storeSuperior'])->name('questionnaire.store-superior');

Route::post('/company', [CompanyController::class, 'store']);

