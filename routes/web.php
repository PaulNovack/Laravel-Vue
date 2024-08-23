<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
})->name('TasksByProject');
Route::get('projects', [ProjectController::class, 'index']);
Route::get('tasks/{project}', [TaskController::class, 'index']);
Route::post('tasks\{project}', [TaskController::class, 'store']);
Route::get('{any?}', function () {
    return view('app');
})->where('any', '.*');
