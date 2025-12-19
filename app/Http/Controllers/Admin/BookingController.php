<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // List all bookings
    public function index()
    {
        $bookings = Booking::with(['user', 'vendor'])
            ->latest()
            ->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    // Show booking details
    public function show(Booking $booking)
    {
        $booking->load(['user', 'vendor']);
        return view('admin.bookings.show', compact('booking'));
    }
}
