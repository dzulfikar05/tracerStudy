<?php

use App\Http\Controllers\Backoffice\Operational\QuestionController;
use App\Http\Controllers\Backoffice\Operational\QuestionnaireController;
use Illuminate\Support\Facades\Route;


Route::prefix('backoffice/questionnaire')->as('backoffice.questionnaire.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [QuestionnaireController::class, 'index'])->name('index');
        Route::get('table', [QuestionnaireController::class, 'initTable'])->name('table');
        Route::post('store', [QuestionnaireController::class, 'store'])->name('store');
        Route::post('edit/{id}', [QuestionnaireController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [QuestionnaireController::class, 'update'])->name('update');
        Route::post('destroy/{id}', [QuestionnaireController::class, 'destroy'])->name('destroy');

        Route::post('/{id}/toggle-status', [QuestionnaireController::class, 'toggleStatus'])->name('toggle-status');

        Route::get('show/{id}', [QuestionnaireController::class, 'show'])->name('show');
        Route::post('{id}/question', [QuestionController::class, 'store'])->name('question.store');
        Route::post('{id}/question/{question}', [QuestionController::class, 'update'])->name('question.update');
        Route::delete('{id}/question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');

        Route::get('show-answer/{id}', [QuestionnaireController::class, 'showAnswer'])->name('show-answer');
        Route::get('answer-table/{id}', [QuestionnaireController::class, 'answerTable'])->name('answer-table');
        Route::post('answer/delete', [QuestionnaireController::class, 'deleteAnswer'])->name('answer.delete');

    });
