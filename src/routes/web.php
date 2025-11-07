<?php

use App\Http\Controllers\TodoController;

Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::post('/todos/{id}/complete', [TodoController::class, 'complete'])->name('todos.complete');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');