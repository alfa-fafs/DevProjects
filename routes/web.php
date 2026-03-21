<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RideHistoryController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentMethodController;

Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment.index');
Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('payment.store');
Route::patch('/payment-methods/{id}/default', [PaymentMethodController::class, 'setDefault'])->name('payment.default');
Route::delete('/payment-methods/{id}', [PaymentMethodController::class, 'destroy'])->name('payment.destroy');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread');

Route::get('/rides/{rideId}/rate', [RatingController::class, 'create'])->name('rides.rate');
Route::post('/rides/{rideId}/rate', [RatingController::class, 'store'])->name('rides.rate.store');

// Root — redirect guests to landing page, logged in users to rides
Route::get('/', function () {
    if (!auth()->check()) return redirect()->route('welcome');
    return view('home.index');
})->name('home');

// Guest pages
Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');

Route::get('/signin', function () {
    return view('auth.signin');
})->middleware('guest')->name('signin');

Route::get('/onboarding', function () {
    return view('onboarding');
})->middleware('guest')->name('onboarding');

Route::get('/phone-register', function () {
    return view('auth.phone-register');
})->middleware('guest')->name('phone.register');

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->middleware('guest')->name('otp.verify');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth required routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/history', [RideHistoryController::class, 'index'])->name('history.index');
    Route::post('/history', [RideHistoryController::class, 'store'])->name('history.store');

    // Recent locations
    Route::post('/save-location', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'location_name' => 'required|string',
            'address'       => 'required|string',
        ]);

        \App\Models\Favorite::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'address' => $request->address,
            ],
            [
                'location_name' => $request->location_name,
            ]
        );

        return response()->json(['ok' => true]);
    });

    Route::get('/recent-locations', function() {
        $locations = \App\Models\Favorite::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get(['location_name', 'address']);

        return response()->json($locations);
    });
});

require __DIR__.'/auth.php';