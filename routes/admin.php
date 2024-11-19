<?php

use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin','middleware' => ['auth', 'admin']], function () {
    /** Usuários */
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    /** Tarefas */
    Route::get('/users/{id}/tasks', [TaskController::class, 'tasksByUser'])->name('admin.users.tasks');
    Route::post('/users/{id}/tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
    Route::put('/users/tasks/{id}', [TaskController::class, 'update'])->name('admin.tasks.update');
    Route::delete('/users/tasks/{id}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
});
