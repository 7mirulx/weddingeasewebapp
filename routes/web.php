<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WeddingPrerequisiteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\OwnershipRequestController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\SettingsController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    $vendors = \App\Models\Vendor::where('status', 'active')
        ->inRandomOrder()
        ->limit(12)
        ->get();
    return view('landing', compact('vendors'));
})->name('home');

// Claim Your Business - Public Pages
Route::get('/claim-business', [VendorController::class, 'claimLanding'])->name('vendor.claim-landing');
Route::get('/vendor/claim', [VendorController::class, 'showClaimForm'])->name('vendor.claim');
Route::post('/vendor/claim/payment', [VendorController::class, 'processPayment'])->name('vendor.claim.process-payment');
Route::post('/vendor/claim', [VendorController::class, 'processClaim'])->name('vendor.claim.process');
Route::get('/vendor/claim/success', [VendorController::class, 'claimSuccess'])->name('vendor.claim.success');

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
        $vendor = \App\Models\Vendor::where('owner_user_id', auth()->id())->first();
        $bookings = $vendor ? $vendor->bookings()->with('user')->latest()->take(5)->get() : collect();
        $totalBookings = $vendor ? $vendor->bookings()->count() : 0;
        $pendingBookings = $vendor ? $vendor->bookings()->where('status', 'prospect')->count() : 0;
        
        // Performance metrics
        $profileViews = $vendor ? ($vendor->profile_views ?? 0) : 0;
        $bookingRate = $totalBookings > 0 && $profileViews > 0 ? round(($totalBookings / $profileViews) * 100, 1) : 0;
        $customerRating = $vendor ? ($vendor->rating_average ?? 0) : 0;
        
        return view('vendor.dashboard', compact('bookings', 'totalBookings', 'pendingBookings', 'profileViews', 'bookingRate', 'customerRating'));
    })->name('vendor.dashboard');

    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/profile/edit', [VendorController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile/update', [VendorController::class, 'updateProfile'])->name('profile.update');
        Route::get('/bookings', [VendorController::class, 'vendorBookings'])->name('bookings.index');
        Route::post('/bookings/{booking}/status', [VendorController::class, 'updateBookingStatus'])->name('bookings.update-status');
        Route::post('/bookings/{booking}/agreed-price', [VendorController::class, 'updateAgreedPrice'])->name('bookings.update-price');
        Route::get('/gallery', [VendorController::class, 'vendorGallery'])->name('gallery.index');
        Route::post('/gallery', [VendorController::class, 'uploadGalleryImage'])->name('gallery.store');
        Route::delete('/gallery/{id}', [VendorController::class, 'deleteGalleryImage'])->name('gallery.delete');
        Route::post('/banner', [VendorController::class, 'uploadBanner'])->name('banner.store');
        Route::delete('/banner', [VendorController::class, 'deleteBanner'])->name('banner.delete');
        Route::get('/pricing', [VendorController::class, 'vendorPricing'])->name('pricing.index');
        Route::post('/pricing', [VendorController::class, 'updatePricing'])->name('pricing.update');
        Route::get('/reviews', [VendorController::class, 'vendorReviews'])->name('reviews.index');
        Route::get('/analytics', [VendorController::class, 'vendorAnalytics'])->name('analytics');
        Route::get('/settings', [VendorController::class, 'vendorSettings'])->name('settings');
    });

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

    Route::get('/vendors/filter', [VendorController::class, 'filterVendors'])
        ->name('vendors.filter');

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

    // Download document
    Route::get('/documents/{document}/download',
        [WeddingPrerequisiteController::class, 'downloadDocument'])
        ->name('documents.download');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Vendors Management
    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/create', [AdminVendorController::class, 'create'])->name('vendors.create');
    Route::post('/vendors', [AdminVendorController::class, 'store'])->name('vendors.store');
    Route::get('/vendors/{vendor}/edit', [AdminVendorController::class, 'edit'])->name('vendors.edit');
    Route::put('/vendors/{vendor}', [AdminVendorController::class, 'update'])->name('vendors.update');
    Route::post('/vendors/{vendor}/toggle-status', [AdminVendorController::class, 'toggleStatus'])->name('vendors.toggle-status');
    Route::post('/vendors/{vendor}/toggle-featured', [AdminVendorController::class, 'toggleFeatured'])->name('vendors.toggle-featured');
    Route::post('/vendors/{vendor}/assign-owner', [AdminVendorController::class, 'assignOwner'])->name('vendors.assign-owner');
    Route::post('/vendors/{vendor}/send-claim-invite', [AdminVendorController::class, 'sendClaimInvite'])->name('vendors.send-claim-invite');
    Route::post('/vendors/{vendor}/generate-token', [AdminVendorController::class, 'generateClaimToken'])->name('vendors.generate-token');
    Route::post('/vendors/contact-business', [AdminVendorController::class, 'contactBusiness'])->name('vendors.contact-business');

    // Ownership Requests
    Route::get('/ownership-requests', [OwnershipRequestController::class, 'index'])->name('ownership-requests.index');
    Route::get('/ownership-requests/{vendorOwnershipRequest}', [OwnershipRequestController::class, 'show'])->name('ownership-requests.show');
    Route::post('/ownership-requests/{vendorOwnershipRequest}/approve', [OwnershipRequestController::class, 'approve'])->name('ownership-requests.approve');
    Route::post('/ownership-requests/{vendorOwnershipRequest}/reject', [OwnershipRequestController::class, 'reject'])->name('ownership-requests.reject');

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Bookings Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');

    // Settings Management
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/categories', [SettingsController::class, 'updateCategories'])->name('settings.categories');
    Route::post('/settings/email-sender', [SettingsController::class, 'updateEmailSender'])->name('settings.email-sender');
});

