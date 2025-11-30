<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingDetailController;

// ---------------------------
// PUBLIC PAGES
// ---------------------------

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ---------------------------
// PROTECTED ROUTES (User must be logged in)
// ---------------------------
Route::middleware('auth')->group(function () {

    // Client dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ⭐ Wedding Setup Routes (ADD HERE)
    Route::get('/wedding/setup', [WeddingDetailController::class, 'create']);
    Route::post('/wedding/setup', [WeddingDetailController::class, 'store']);

    // Vendor dashboard
    Route::get('/vendor', function () {
        return "Vendor Dashboard (coming soon)";
    })->name('vendor.dashboard');

    // Admin dashboard
    Route::get('/admin', function () {
        return "Admin Panel (coming soon)";
    })->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'index']);
    
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/wedding', [ProfileController::class, 'updateWedding']);

});
