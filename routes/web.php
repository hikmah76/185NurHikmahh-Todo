<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Mail;

Mail::raw('Ini adalah tes email dari Laravel', function ($message) {
    $message->to('test@example.com')
            ->subject('Coba Kirim Email');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group untuk user yang sudah login dan sudah verifikasi email
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Todo Routes
    Route::resource('todo', TodoController::class)->except(['show']);
    Route::delete('todo/completed', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');

    // Category Routes
    Route::resource('category', CategoryController::class);
});

// Group khusus admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class)->except(['show']);
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
});

// Route auth bawaan Laravel Breeze/Fortify/etc
require __DIR__.'/auth.php';
