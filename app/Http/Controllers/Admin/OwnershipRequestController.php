<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorOwnershipRequest;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\OwnershipApprovedMail;
use Illuminate\Support\Facades\Mail;

class OwnershipRequestController extends Controller
{
    // List all ownership requests
    public function index()
    {
        $requests = VendorOwnershipRequest::with(['user', 'vendor', 'reviewer'])
            ->latest()
            ->paginate(15);
        return view('admin.ownership-requests.index', compact('requests'));
    }

    // Show request details
    public function show(VendorOwnershipRequest $request)
    {
        $request->load(['user', 'vendor', 'reviewer']);
        return view('admin.ownership-requests.show', compact('request'));
    }

    // Approve request
    public function approve(VendorOwnershipRequest $ownershipRequest)
    {
        if ($ownershipRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed');
        }

        // Generate credentials
        $password = Str::random(12);
        $email = $ownershipRequest->user->email;
        $name = $ownershipRequest->user->name;

        // Create vendor user account if user doesn't have vendor role
        if ($ownershipRequest->user->role !== 'vendor') {
            $ownershipRequest->user->update(['role' => 'vendor']);
        }

        // Assign vendor to user
        $ownershipRequest->vendor->update([
            'owner_user_id' => $ownershipRequest->user->id,
            'status' => 'active'
        ]);

        // Update ownership request status
        $ownershipRequest->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        // Send email with credentials
        Mail::to($email)->send(new OwnershipApprovedMail($name, $email, $password));

        // Update password
        $ownershipRequest->user->update([
            'password' => Hash::make($password)
        ]);

        return back()->with('success', 'Ownership request approved! Credentials sent to vendor email.');
    }

    // Reject request
    public function reject(VendorOwnershipRequest $ownershipRequest)
    {
        if ($ownershipRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed');
        }

        $ownershipRequest->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        return back()->with('success', 'Ownership request rejected');
    }
}
