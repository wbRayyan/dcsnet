<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\ServiceJobController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Cars
    Route::apiResource('cars', CarController::class);

    // Mechanics
    Route::apiResource('mechanics', MechanicController::class);

    // Service Jobs
    Route::apiResource('service-jobs', ServiceJobController::class)
         ->except(['update', 'destroy']);
    Route::patch('service-jobs/{id}/status',   [ServiceJobController::class, 'updateStatus']);
    Route::patch('service-jobs/{id}/assign',   [ServiceJobController::class, 'assignMechanic']);
});