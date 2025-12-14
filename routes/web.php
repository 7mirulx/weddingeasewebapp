<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WeddingPrerequisiteController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/vendor', function () {
        return "Vendor Dashboard (coming soon)";
    })->name('vendor.dashboard');

    Route::get('/admin', function () {
        return "Admin Panel (coming soon)";
    })->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | WEDDING SETUP
    |--------------------------------------------------------------------------
    */

    Route::get('/wedding/setup', [WeddingDetailController::class, 'create'])
        ->name('wedding.setup');

    Route::post('/wedding/setup', [WeddingDetailController::class, 'store'])
        ->name('wedding.store');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])
        ->name('profile.update');

    Route::post('/profile/wedding', [ProfileController::class, 'updateWedding'])
        ->name('profile.wedding');


    /*
    |--------------------------------------------------------------------------
    | VENDORS
    |--------------------------------------------------------------------------
    */

    Route::get('/vendors', [VendorController::class, 'index'])
        ->name('vendors.index');

    Route::get('/vendors/search', [VendorController::class, 'search'])
        ->name('vendors.search');

    Route::get('/vendors/fetch/{id}', [VendorController::class, 'fetch'])
        ->name('vendors.fetch');

    Route::get('/vendors/{id}', [VendorController::class, 'show'])
        ->name('vendors.show');

    Route::get('/myvendors', [VendorController::class, 'myVendors'])
        ->name('vendors.my');

    Route::post('/myvendors/add', [VendorController::class, 'storeUserVendor'])
        ->name('vendors.add');

    Route::delete('/myvendors/delete/{id}', [VendorController::class, 'deleteuservendor'])
        ->name('vendors.delete');

    Route::put('/myvendors/update/{id}', [VendorController::class, 'updateBooking'])
        ->name('vendors.update');

    Route::post('/myvendors/rate/{booking}', [VendorController::class, 'rate'])
        ->name('vendors.rate');


    /*
    |--------------------------------------------------------------------------
    | PRA-NIKAH CHECKLIST (DB-DRIVEN)
    |--------------------------------------------------------------------------
    */

    // View checklist
    Route::get('/preweddingpreparation', [WeddingPrerequisiteController::class, 'index'])
        ->name('preweddingpreparation.index');

    // Update a step (mark completed / submitted)
    Route::post('/preweddingpreparation/{prerequisite}', 
        [WeddingPrerequisiteController::class, 'update'])
        ->name('preweddingpreparation.update');

    // Upload document for a step
    Route::post('/preweddingpreparation/{prerequisite}/upload',
        [WeddingPrerequisiteController::class, 'uploadDocument'])
        ->name('preweddingpreparation.upload');

    // Delete uploaded document
    Route::delete('/preweddingpreparation/document/{document}',
        [WeddingPrerequisiteController::class, 'deleteDocument'])
        ->name('preweddingpreparation.document.delete');

});
