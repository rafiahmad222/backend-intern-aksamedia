<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Admin;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'webLogin']);

Route::get('/dashboard', function () {
    // Check if user is logged in
    if (!session('admin_id')) {
        return redirect()->route('login');
    }
    return view('dashboard');
})->name('dashboard');

Route::get('/profile', function () {
    // Check if user is logged in
    if (!session('admin_id')) {
        return redirect()->route('login');
    }
    return view('profile');
})->name('profile');

Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

// Register route (optional)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
