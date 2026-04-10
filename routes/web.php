<?php

use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
