<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ModuleController::class, 'index'])->name('modules.index');

Route::get('/module/{module:slug}', [QuizController::class, 'show'])->name('quiz.show');
