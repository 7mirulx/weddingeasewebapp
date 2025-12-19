<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Booking;
use App\Models\VendorOwnershipRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalVendors = Vendor::count();
        $totalBookings = Booking::count();
        $pendingRequests = VendorOwnershipRequest::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalVendors',
            'totalBookings',
            'pendingRequests'
        ));
    }
}
