<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\AdminRideController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Test route to verify API is working
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working, Dr Fafs!'
    ]);
});

use App\Http\Controllers\Api\AuthController;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);

// Login route
Route::post('/login', [AuthController::class, 'login']);

// Protected route to get user profile
Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});

// Logout route
Route::any('/check-method', function () {
    return request()->method();
});


use App\Http\Controllers\Api\RideController;

// Protected routes for rides and favorites
Route::middleware('auth:sanctum')->group(function () {

    //Rutes
    Route::post('/rides', [RideController::class, 'store']);
    Route::get('/rides', [RideController::class, 'index']);
    Route::post('/rides/{ride}/select-provider', [RideController::class, 'selectProvider']);
    Route::patch('/rides/{ride}/complete', [RideController::class, 'completeRide']);
    Route::patch('/rides/{ride}/cancel', [RideController::class, 'cancel']);

    //Favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy']);
    });

    // Admin-only routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::get('/admin/test', function () {
        return response()->json([
            'message' => 'Welcome Admin 🔥😁🫡'
        ]);
    });

    // Admin ride management routes
    Route::get('/admin/rides', [AdminRideController::class, 'index']);

    // Admin route to view ride details
    Route::get('/admin/rides/{id}', [AdminRideController::class, 'show']);

    // Admin route to update ride status
    Route::patch('/admin/rides/{id}/status', [AdminRideController::class, 'updateStatus']);
});