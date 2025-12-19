<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorRating;
use App\Models\booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    // ================================
    // PUBLIC DIRECTORY
    // ================================
    public function index(Request $request)
    {
        $vendors = Vendor::with('reviews.user')
            ->when($request->search, fn($q) =>
                $q->where('vendor_name', 'ILIKE', "%{$request->search}%")
            )
            ->when($request->category, fn($q) =>
                $q->where('category', $request->category)
            )
            ->when($request->city, fn($q) =>
                $q->where('city', $request->city)
            )
            ->whereNotNull('owner_user_id') // only claimed vendors
            ->paginate(12);

        $categories = Vendor::select('category')->distinct()->get();
        $cities     = Vendor::select('city')->distinct()->get();

        return view('wedding.browsevendors', compact('vendors', 'categories', 'cities'));
    }

    // AJAX FILTER ENDPOINT
    public function filterVendors(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $vendors = Vendor::select('id', 'vendor_name', 'category', 'city', 'state', 'starting_price', 'banner_url', 'rating_average', 'rating_count', 'description', 'phone', 'email')
            ->with('reviews.user')
            ->when($request->search, fn($q) =>
                $q->where('vendor_name', 'ILIKE', "%{$request->search}%")
            )
            ->when($request->category, fn($q) =>
                $q->where('category', $request->category)
            )
            ->when($request->city, fn($q) =>
                $q->where('city', $request->city)
            )
            ->whereNotNull('owner_user_id') // only claimed vendors
            ->get();

        $bookedVendorIds = auth()->user()->bookings->pluck('vendor_id')->toArray();

        return response()->json([
            'status' => 'success',
            'vendors' => $vendors,
            'bookedVendorIds' => $bookedVendorIds
        ]);
    }

    public function show($id)
    {
        $booking = Booking::with('vendor')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('wedding.vendor-details', compact('booking'));
    }


    // ================================
    // CLIENT VENDORS
    // ================================
    public function myVendors()
    {
        $vendors = Booking::with(['vendor', 'rating'])
            ->where('user_id', auth()->id())
            ->get();

        return view('wedding.myvendors', compact('vendors'));
    }


    // SEARCH API (for autocomplete)
    public function search(Request $request)
    {
        $term = $request->input('q', '');
        $vendors = Vendor::whereNotNull('owner_user_id')
            ->where('vendor_name', 'ILIKE', "%{$term}%")
            ->select('id', 'vendor_name', 'starting_price', 'phone', 'email', 'description', 'service_ids')
            ->limit(8)
            ->get();

        return response()->json($vendors);
    }

    // ADD OR DUPLICATE
    public function storeUserVendor(Request $request)
    {
        $validated = $request->validate([
            'vendor_name'    => 'required|string|max:255',
            'service_ids'    => 'nullable|array',
            'service_ids.*'  => 'integer',
            'starting_price' => 'nullable|numeric',
            'phone'          => 'nullable|string',
            'email'          => 'nullable|email',
            'description'    => 'nullable|string',
        ]);

        // ---------------------------------------------------
        // 1️⃣ CHECK IF VENDOR EXISTS (PUBLIC VENDOR)
        // ---------------------------------------------------
        $existingVendor = Vendor::whereNull('owner_user_id')
            ->where('vendor_name', 'ILIKE', $validated['vendor_name'])
            ->first();

        if ($existingVendor) {
            // Use existing public vendor
            $vendor = $existingVendor;
        } else {
            // ---------------------------------------------------
            // 2️⃣ CREATE NEW VENDOR (linked via created_by_id, not owner_user_id)
            // ---------------------------------------------------
            $vendorData = $validated;
            $vendorData['owner_user_id'] = null;  // Keep as NULL
            $vendorData['created_by_id'] = auth()->id();  // Track who created it
            $vendorData['created_by_type'] = 'client';  // Created by client user
            $vendor = Vendor::create($vendorData);
        }

        // ---------------------------------------------------
        // 3️⃣ CREATE BOOKING (ALWAYS)
        // ---------------------------------------------------
        Booking::create([
            'user_id'    => auth()->id(),
            'vendor_id'  => $vendor->id,
            'payment_progress' => [
                'deposit' => $request->deposit ?? 0,
            ],
            'is_completed' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'vendor_id' => $vendor->id
        ]);
    }



    public function deleteuservendor(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $booking->delete();

        $message = 'Vendor removed from your bookings.';

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->back()->with('success', $message);
    }


    public function fetch($id)
    {
        $vendor = Vendor::select('id', 'vendor_name', 'service_ids', 'starting_price', 'phone', 'email', 'description')
            ->findOrFail($id);

        return response()->json($vendor);
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        // Store payments as JSON - handle both field names
        if ($request->has('payment_progress')) {
            $booking->payment_progress = $request->payment_progress;
        } elseif ($request->has('payments_json')) {
            $booking->payment_progress = $request->payments_json;
        }

        // Update agreed price
        if ($request->has('agreed_price')) {
            $booking->agreed_price = $request->agreed_price;
        }

        // Update completion status
        if ($request->has('is_completed')) {
            $booking->is_completed = $request->is_completed == 1;
        }

        $booking->save();

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Booking updated successfully!']);
        }

        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function rate(Request $request, $booking_id)
    {
        // Validate rating with custom messages
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }
            throw $e;
        }

        // Find booking owned by this user
        $booking = Booking::with('vendor')
            ->where('user_id', auth()->id())
            ->findOrFail($booking_id);

        // Prevent duplicate ratings for same booking
        $existing = VendorRating::where('booking_id', $booking->id)->first();
        if ($existing) {
            $message = 'You have already rated this vendor.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 400);
            }
            return back()->with('error', $message);
        }

        // Save rating
        VendorRating::create([
            'vendor_id'  => $booking->vendor_id,
            'booking_id' => $booking->id,
            'user_id'    => auth()->id(),
            'rating'     => $validated['rating'],
            'review'     => $validated['review'] ?? null,
        ]);

        // Recalculate vendor rating average
        $vendor = $booking->vendor;

        $vendor->rating_average = VendorRating::where('vendor_id', $vendor->id)->avg('rating');
        $vendor->rating_count   = VendorRating::where('vendor_id', $vendor->id)->count();
        $vendor->save();

        $message = 'Thank you for rating this vendor!';

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    // ================================
    // VENDOR CLAIM FLOW
    // ================================
    
    /**
     * Show claim business landing page
     */
    public function claimLanding()
    {
        return view('vendor.claim-landing');
    }

    /**
     * Show claim form with vendor preview
     */
    public function showClaimForm(Request $request)
    {
        $token = $request->query('token');
        
        if (!$token) {
            return redirect()->route('vendor.claim-landing')
                ->with('error', 'No claim token provided.');
        }

        // Find valid token
        $claimToken = \App\Models\VendorClaimToken::with('vendor')
            ->where('token', $token)
            ->first();

        // Validate token exists and is not expired/used
        if (!$claimToken || !$claimToken->isValid()) {
            return redirect()->route('vendor.claim-landing')
                ->with('error', 'Claim token is invalid or has expired.');
        }

        // Check vendor is still unclaimed
        if (!$claimToken->vendor->isUnclaimed()) {
            return redirect()->route('vendor.claim-landing')
                ->with('error', 'This vendor has already been claimed.');
        }

        $vendor = $claimToken->vendor;

        return view('vendor.claim-form', compact('vendor', 'claimToken'));
    }

    /**
     * Process payment for claim
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'card_holder_name' => 'required|string',
            'card_number' => 'required|regex:/^\d{16}$/',
            'expiry_date' => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|regex:/^\d{3}$/',
            'payment_amount' => 'required|numeric|min:99',
        ]);

        try {
            // Validate token exists
            $claimToken = \App\Models\VendorClaimToken::where('token', $validated['token'])->first();
            
            if (!$claimToken || !$claimToken->isValid()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid or expired claim token.'
                ], 422);
            }

            // Process payment (simulated - in production, use Stripe, PayPal, etc.)
            // For now, we'll just validate and approve
            $paymentId = 'PAY-' . strtoupper(uniqid());
            
            \Log::info('Payment Processed', [
                'payment_id' => $paymentId,
                'vendor_id' => $claimToken->vendor_id,
                'amount' => $validated['payment_amount'],
                'cardholder' => $validated['card_holder_name'],
                'timestamp' => now(),
            ]);

            // Return success with claim token
            return response()->json([
                'status' => 'payment_success',
                'payment_id' => $paymentId,
                'claim_token' => $validated['token'],
                'message' => 'Payment processed successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Payment Processing Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process vendor claim submission
     */
    public function processClaim(Request $request)
    {
        $token = $request->input('token');
        
        // Validate token
        $claimToken = \App\Models\VendorClaimToken::with('vendor')
            ->where('token', $token)
            ->first();

        if (!$claimToken || !$claimToken->isValid()) {
            $error = 'Claim token is invalid or has expired.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $error], 422);
            }
            return back()->with('error', $error);
        }

        $vendor = $claimToken->vendor;

        if (!$vendor->isUnclaimed()) {
            $error = 'This vendor has already been claimed.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $error], 422);
            }
            return back()->with('error', $error);
        }

        // Only allow registration - no login option
        // Register new user as vendor using vendor's business name and email
        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        try {
            $user = User::create([
                'name' => $vendor->vendor_name,
                'email' => $vendor->email,
                'password' => Hash::make($data['password']),
                'role' => 'vendor',
            ]);

            \Auth::login($user);
        } catch (\Exception $e) {
            $error = 'Failed to create vendor account. Please try again.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $error], 500);
            }
            return back()->with('error', $error);
        }

        // Claim the vendor
        $vendor->update([
            'status' => 'claimed',
            'owner_user_id' => $user->id,
            'claimed_at' => now(),
        ]);

        // Mark token as used
        $claimToken->markAsUsed();

        // Log successful claim
        \Log::info('Vendor Claimed Successfully', [
            'vendor_id' => $vendor->id,
            'vendor_name' => $vendor->vendor_name,
            'owner_id' => $user->id,
            'owner_email' => $user->email,
            'timestamp' => now(),
        ]);

        // Handle AJAX requests
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Vendor claimed successfully!',
                'vendor_id' => $vendor->id,
                'redirect_url' => route('vendor.claim.success')
            ]);
        }

        // Redirect to success page for regular requests
        return redirect()->route('vendor.claim.success')
            ->with('success', 'Vendor claimed successfully!')
            ->with('vendor_id', $vendor->id);
    }

    /**
     * Show claim success page
     */
    public function claimSuccess()
    {
        $vendorId = session('vendor_id');
        
        if (!$vendorId) {
            return redirect()->route('vendor.claim-landing');
        }

        $vendor = Vendor::findOrFail($vendorId);

        // Verify user owns this vendor
        if ($vendor->owner_user_id !== auth()->id()) {
            return redirect('/dashboard');
        }

        return view('vendor.claim-success', compact('vendor'));
    }

    // ================================
    // VENDOR DASHBOARD ROUTES
    // ================================
    public function editProfile()
    {
        // Get the vendor profile for the logged-in user (vendor owner)
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        return view('vendor.profile.edit', compact('vendor'));
    }

    public function updateProfile(Request $request)
    {
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'postcode' => 'nullable|string',
            'address' => 'nullable|string',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer',
        ]);

        // Convert service_ids to array if provided
        if (isset($validated['service_ids'])) {
            $validated['service_ids'] = array_map('intval', $validated['service_ids']);
        } else {
            $validated['service_ids'] = [];
        }

        $vendor->update($validated);
        
        return redirect()->route('vendor.profile.edit')->with('success', 'Profile updated successfully');
    }

    public function vendorBookings()
    {
        // Get all bookings for the logged-in vendor with related user info
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        $bookings = Booking::where('vendor_id', $vendor->id)
            ->with(['user', 'user.weddingDetails'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                $booking->days_until_wedding = $booking->getDaysUntilWedding();
                return $booking;
            });
        
        return view('vendor.bookings.index', compact('bookings', 'vendor'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        // Ensure the vendor owns this booking
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        if ($booking->vendor_id !== $vendor->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => 'required|in:prospect,contacted,ready,completed',
        ]);

        $booking->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Booking status updated successfully');
    }

    public function updateAgreedPrice(Request $request, Booking $booking)
    {
        // Ensure the vendor owns this booking
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        if ($booking->vendor_id !== $vendor->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'agreed_price' => 'required|numeric|min:0',
        ]);

        $booking->update(['agreed_price' => $validated['agreed_price']]);

        return redirect()->back()->with('success', 'Agreed price updated successfully');
    }

    public function vendorGallery()
    {
        // Get gallery images for the vendor (max 4)
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        $gallery = $vendor->gallery ?? [];
        
        return view('vendor.gallery.index', compact('vendor', 'gallery'));
    }

    public function uploadGalleryImage(Request $request)
    {
        try {
            $vendor = Vendor::where('owner_user_id', auth()->id())->first();
            
            if (!$vendor) {
                return response()->json(['error' => 'Vendor not found'], 404);
            }
            
            // Check max 4 images
            $currentGallery = $vendor->gallery ?? [];
            if (count($currentGallery) >= 4) {
                return response()->json(['error' => 'Maximum 4 images allowed'], 422);
            }

            // Validate image
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Check if file exists
            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                return response()->json(['error' => 'Invalid image file'], 422);
            }

            // Store the file
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('vendor-gallery', $filename, 'public');
            
            if (!$path) {
                return response()->json(['error' => 'Failed to store image'], 500);
            }
            
            // Update vendor gallery
            $currentGallery[] = $path;
            $vendor->update(['gallery' => $currentGallery]);

            return response()->json([
                'success' => true,
                'path' => asset('storage/' . $path)
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()['image'][0] ?? 'Validation failed'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteGalleryImage(Request $request, $imageIndex)
    {
        $vendor = Vendor::where('owner_user_id', auth()->id())->first();
        
        if (!$vendor) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }
        
        $gallery = $vendor->gallery ?? [];
        
        if (isset($gallery[$imageIndex])) {
            // Delete the file if needed
            unset($gallery[$imageIndex]);
            $gallery = array_values($gallery); // Re-index array
            $vendor->update(['gallery' => $gallery]);
            
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Image not found'], 404);
    }

    public function uploadBanner(Request $request)
    {
        try {
            $vendor = Vendor::where('owner_user_id', auth()->id())->first();
            
            if (!$vendor) {
                return response()->json(['error' => 'Vendor not found'], 404);
            }

            // Validate image
            $request->validate([
                'banner' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
            ]);

            // Check if file exists
            if (!$request->hasFile('banner') || !$request->file('banner')->isValid()) {
                return response()->json(['error' => 'Invalid image file'], 422);
            }

            // Delete old banner if it exists
            if ($vendor->banner_url && file_exists(public_path('image/' . $vendor->banner_url))) {
                unlink(public_path('image/' . $vendor->banner_url));
            }

            // Store the file with vendor_name as filename
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = $vendor->vendor_name . '.' . $extension;
            
            // Move file directly to public/image directory
            $destination = public_path('image');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            
            // Verify file was uploaded
            if (!file_exists(public_path('image/' . $filename))) {
                return response()->json(['error' => 'Failed to store banner'], 500);
            }
            
            // Update vendor banner_url with just the filename
            $vendor->update(['banner_url' => $filename]);

            return response()->json([
                'success' => true,
                'message' => 'Banner uploaded successfully',
                'path' => asset('image/' . $filename)
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()['banner'][0] ?? 'Validation failed'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBanner(Request $request)
    {
        try {
            $vendor = Vendor::where('owner_user_id', auth()->id())->first();
            
            if (!$vendor) {
                return response()->json(['error' => 'Vendor not found'], 404);
            }

            // Delete the banner file from storage if it exists
            if ($vendor->banner_url) {
                $filePath = 'public/image/' . $vendor->banner_url;
                if (file_exists(public_path('image/' . $vendor->banner_url))) {
                    unlink(public_path('image/' . $vendor->banner_url));
                }
            }

            // Update vendor to remove banner_url
            $vendor->update(['banner_url' => null]);

            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function vendorPricing()
    {
        // Get pricing information for the vendor
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        return view('vendor.pricing.index', compact('vendor'));
    }

    public function updatePricing(Request $request)
    {
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        $validated = $request->validate([
            'starting_price' => 'required|numeric|min:0',
        ]);

        $vendor->update($validated);
        
        return redirect()->route('vendor.pricing.index')->with('success', 'Pricing updated successfully');
    }

    public function vendorReviews()
    {
        // Get reviews for the vendor
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        $reviews = VendorRating::where('vendor_id', $vendor->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('vendor.reviews.index', compact('vendor', 'reviews'));
    }

    public function vendorAnalytics()
    {
        // Get analytics for the vendor
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        $totalBookings = Booking::where('vendor_id', $vendor->id)->count();
        $completedBookings = Booking::where('vendor_id', $vendor->id)
            ->where('status', 'completed')
            ->count();
        $pendingBookings = Booking::where('vendor_id', $vendor->id)
            ->whereIn('status', ['prospect', 'contacted', 'ready'])
            ->count();
        
        $averageRating = $vendor->rating_average;
        $totalRatings = $vendor->rating_count;
        
        return view('vendor.analytics', compact('vendor', 'totalBookings', 'completedBookings', 'pendingBookings', 'averageRating', 'totalRatings'));
    }

    public function vendorSettings()
    {
        // Get vendor settings
        $vendor = Vendor::where('owner_user_id', auth()->id())->firstOrFail();
        
        return view('vendor.settings', compact('vendor'));
    }


}

