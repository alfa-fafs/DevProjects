<?php

use Illuminate\Support\Facades\Route;
use App\Models\Ride;


Route::get('/', function () {
    return view('home.index');
})->name('home');
use App\Http\Controllers\AuthController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');