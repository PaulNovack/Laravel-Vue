<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
})->name('TasksByProject');

Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::delete('{project}', [ProjectController::class, 'delete']);
});

Route::prefix('task')->group(function () {
    Route::get('{project}', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::post('/order', [TaskController::class, 'order']);
    Route::delete('{task}', [TaskController::class, 'delete']);
});

Route::get('{any?}', function () {
    return view('app');
})->where('any', '.*');
