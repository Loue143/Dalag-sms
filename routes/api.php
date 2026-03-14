<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentApplicationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Login Token)
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/applications', [StudentApplicationController::class, 'store']);
    Route::get('/applications', [StudentApplicationController::class, 'index']);
    Route::delete('/applications/{id}', [StudentApplicationController::class, 'destroy']);
});