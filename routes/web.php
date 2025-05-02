<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Todo Routes
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit'); // Fixed this
    // 
    Route::patch('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update'); // Fixed this
    Route::delete('/todo/{todo}/', [TodoController::class, 'destroy'])->name('todo.destroy');
    Route::patch('/todo', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallCompleted');
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    // User Routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Fixed this
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');

    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy'); 



});

require __DIR__.'/auth.php';
