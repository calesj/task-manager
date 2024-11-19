<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin','middleware' => ['auth', 'admin']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

    Route::get('/users/{userId}/tasks', [TaskController::class, 'tasksByUser'])->name('admin.users.tasks');

    Route::put('/users/{userId}/update', [UserController::class, 'update'])->name('admin.users.update');
});
