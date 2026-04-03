<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentApplicationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Login Token)
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- Admin Dashboard ---
    Route::get('/admin/applications/pending', [AdminController::class, 'getPendingApplications']);
    Route::patch('/admin/applications/{id}/approve', [AdminController::class, 'approveApplication']);
    Route::patch('/admin/applications/{id}/reject', [AdminController::class, 'rejectApplication']);
    Route::get('/admin/reports/grantees', [AdminController::class, 'getApprovedGrantees']);
    
    // --- Student Application Portal ---
    // 1. Submit/Manage the main application
    Route::post('/applications', [StudentApplicationController::class, 'store']);
    Route::get('/applications', [StudentApplicationController::class, 'index']);
    Route::delete('/applications/{id}', [StudentApplicationController::class, 'destroy']);

    // 2. Update specific application sections (These match your Postman setup!)
    Route::put('/student/profile', [StudentApplicationController::class, 'updateProfile']);
    Route::put('/student/academic', [StudentApplicationController::class, 'updateAcademic']);
    Route::put('/student/family', [StudentApplicationController::class, 'updateFamily']);
    Route::post('/student/documents', [StudentApplicationController::class, 'uploadDocuments']);
});