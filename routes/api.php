<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FareController;
// Save a location
Route::post('/save-location', function(\Illuminate\Http\Request $request) {
    if (!auth('web')->check()) return response()->json(['ok' => false]);

    $request->validate([
        'location_name' => 'required|string',
        'address'       => 'required|string',
    ]);

    Favorite::updateOrCreate(
        [
            'user_id' => auth('web')->id(),
            'address' => $request->address,
        ],
        [
            'location_name' => $request->location_name,
        ]
    );

    return response()->json(['ok' => true]);
});

// Get recent locations
Route::get('/recent-locations', function() {
    if (!auth('web')->check()) return response()->json([]);

    $locations = Favorite::where('user_id', auth('web')->id())
        ->latest()
        ->take(5)
        ->get(['location_name', 'address']);

    return response()->json($locations);
});
Route::get('/fares', [FareController::class, 'calculate']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working, Dr Fafs!'
    ]);
});

use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});

Route::any('/check-method', function () {
    return request()->method();
});
