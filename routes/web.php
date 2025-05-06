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

    Route::resource('todo', TodoController::class)->except(['show']); 
    Route::delete('todo/', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallCompleted');
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('user', UserController::class)->except(['show']); 
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin'); 
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');


});

require __DIR__.'/auth.php';
