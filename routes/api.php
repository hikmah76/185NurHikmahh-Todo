<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;

// Endpoint untuk mendapatkan user yang sedang login (butuh token)
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint login (tidak perlu auth)
Route::post('/login', [AuthController::class, 'login']);

// Semua endpoint ini hanya bisa diakses jika user sudah login (auth:api)
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/todos/search', [TodoController::class, 'search']);
    Route::apiResource('/todos', TodoController::class);
});
