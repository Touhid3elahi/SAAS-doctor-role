<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::post('/register', [RegistrationController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor-profile', [DoctorController::class, 'index']);
        Route::post('/create-appointment', [DoctorController::class, 'createAppointment']);
    });

    Route::middleware(['role:patient'])->group(function () {
        Route::get('/patient-profile', [PatientController::class, 'index']);
        Route::post('/create-appointment', [PatientController::class, 'createAppointment']);
    });

    Route::middleware(['role:vendor'])->group(function () {
        Route::get('/vendors', [VendorController::class, 'index']);

        // Show a specific vendor/organization
        Route::get('/vendors/{vendor}', [VendorController::class, 'show']);

        // Create a new vendor/organization
        Route::post('/vendors', [VendorController::class, 'store']);

        // Update a vendor/organization
        Route::put('/vendors/{vendor}', [VendorController::class, 'update']);

        // Delete a vendor/organization
        Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy']);
    });

    Route::get('/user-profile', [UserController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes for managing roles and permissions
    Route::middleware(['role:admin'])->group(function () {
        // List all roles
        Route::get('/roles', [RoleController::class, 'index']);

        // Create a new role
        Route::post('/roles', [RoleController::class, 'store']);

        // Show a specific role
        Route::get('/roles/{role}', [RoleController::class, 'show']);

        // Update a role
        Route::put('/roles/{role}', [RoleController::class, 'update']);

        // Delete a role
        Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

        // List all permissions
        Route::get('/permissions', [PermissionController::class, 'index']);

        // Create a new permission
        Route::post('/permissions', [PermissionController::class, 'store']);

        // Show a specific permission
        Route::get('/permissions/{permission}', [PermissionController::class, 'show']);

        // Update a permission
        Route::put('/permissions/{permission}', [PermissionController::class, 'update']);

        // Delete a permission
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy']);
    });
});
