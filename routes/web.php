<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Tasks Routes
Route::get('/dashboard', [TaskController::class, "index"])->name('menu.index');
Route::post('/dashboard/tasks/process/add', [TaskController::class, 'store'])->name('tasks.store');
