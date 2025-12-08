<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorRating;
use App\Models\booking;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // ================================
    // PUBLIC DIRECTORY
    // ================================
    public function index(Request $request)
    {
        $vendors = Vendor::query()
            ->when($request->search, fn($q) =>
                $q->where('vendor_name', 'ILIKE', "%{$request->search}%")
            )
            ->when($request->category, fn($q) =>
                $q->where('category', $request->category)
            )
            ->when($request->city, fn($q) =>
                $q->where('city', $request->city)
            )
            ->whereNull('owner_user_id') // only official vendors
            ->paginate(12);

        $categories = Vendor::select('category')->distinct()->get();
        $cities     = Vendor::select('city')->distinct()->get();

        return view('wedding.browsevendors', compact('vendors', 'categories', 'cities'));
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
        $vendors = Booking::with('vendor')
            ->where('user_id', auth()->id())
            ->get();

        return view('wedding.myvendors', compact('vendors'));
    }


    // SEARCH API (for autocomplete)
    public function search(Request $request)
    {
        $term = $request->input('q', '');
        $vendors = Vendor::whereNull('owner_user_id')
            ->where('vendor_name', 'ILIKE', "%{$term}%")
            ->select('id', 'vendor_name', 'starting_price')
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

        // Add owner info
        $validated['owner_user_id']   = auth()->id();
        $validated['created_by_id']   = auth()->id();
        $validated['created_by_type'] = 'client';

        // ---------------------------------------------------
        // 1️⃣ CHECK IF VENDOR EXISTS (PUBLIC VENDOR)
        // ---------------------------------------------------
        $existingVendor = Vendor::whereNull('owner_user_id')
            ->where('vendor_name', 'ILIKE', $validated['vendor_name'])
            ->first();

        if ($existingVendor) {
            // Use existing vendor → DO NOT create vendor
            $vendor = $existingVendor;
        } else {
            // ---------------------------------------------------
            // 2️⃣ CREATE NEW PRIVATE VENDOR
            // ---------------------------------------------------
            $vendor = Vendor::create($validated);
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

        return redirect()->back()->with('success', 'Vendor & Booking saved successfully!');
    }



    public function deleteuservendor($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully.');
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

        $booking->payment_progress = [
            'deposit' => $request->deposit ?? 0,
        ];

        $booking->is_completed = $request->is_completed == 1;

        $booking->save();

        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function rate(Request $request, $booking_id)
    {
        // Validate rating
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        // Find booking owned by this user
        $booking = Booking::with('vendor')
            ->where('user_id', auth()->id())
            ->findOrFail($booking_id);

        // Prevent duplicate ratings for same booking
        $existing = VendorRating::where('booking_id', $booking->id)->first();
        if ($existing) {
            return back()->with('error', 'You have already rated this vendor.');
        }

        // Save rating
        VendorRating::create([
            'vendor_id'  => $booking->vendor_id,
            'booking_id' => $booking->id,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'review'     => $request->review,
        ]);

        // Recalculate vendor rating average
        $vendor = $booking->vendor;

        $vendor->rating_average = VendorRating::where('vendor_id', $vendor->id)->avg('rating');
        $vendor->rating_count   = VendorRating::where('vendor_id', $vendor->id)->count();
        $vendor->save();

        return back()->with('success', 'Thank you for rating this vendor!');
    }

}
