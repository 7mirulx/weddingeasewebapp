<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Mail\VendorClaimInviteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{
    // List all vendors
    public function index()
    {
        $vendors = Vendor::paginate(15);
        return view('admin.vendors.index', compact('vendors'));
    }

    // Show create form
    public function create()
    {
        return view('admin.vendors.create');
    }

    // Store new vendor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'starting_price' => 'nullable|numeric',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $validated['created_by_type'] = 'admin';
        $validated['created_by_id'] = auth()->id();
        $validated['status'] = 'unclaimed';

        Vendor::create($validated);
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully');
    }

    // Show edit form
    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    // Update vendor
    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'starting_price' => 'nullable|numeric',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|in:unclaimed,claimed,active,inactive,pending,suspended',
            'is_featured' => 'boolean',
        ]);

        $vendor->update($validated);
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully');
    }

    // Toggle vendor status
    public function toggleStatus(Vendor $vendor)
    {
        $vendor->status = $vendor->status === 'active' ? 'inactive' : 'active';
        $vendor->save();
        return back()->with('success', 'Vendor status updated');
    }

    // Toggle featured status
    public function toggleFeatured(Vendor $vendor)
    {
        $vendor->is_featured = !$vendor->is_featured;
        $vendor->save();
        return back()->with('success', 'Featured status updated');
    }

    // Assign owner
    public function assignOwner(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'owner_user_id' => 'nullable|exists:users,id',
        ]);

        $vendor->owner_user_id = $validated['owner_user_id'];
        $vendor->save();
        return back()->with('success', 'Owner assigned successfully');
    }

    // Send claim invite to vendor
    public function sendClaimInvite(Request $request, Vendor $vendor)
    {
        // Only send to unclaimed vendors
        if (!$vendor->isUnclaimed()) {
            return back()->with('error', 'This vendor has already been claimed.');
        }

        // Validate vendor has email
        if (!$vendor->email) {
            return back()->with('error', 'Vendor does not have an email address.');
        }

        try {
            // Generate claim token
            $token = $vendor->generateClaimToken();

            // Send email
            Mail::send(new VendorClaimInviteMail($vendor, $token));

            return back()->with('success', 'Claim invitation sent to vendor email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation: ' . $e->getMessage());
        }
    }

    // Contact business - send email with claim link and record payment
    public function contactBusiness(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'subject' => 'required|string',
            'email_content' => 'required|string',
            'claim_link' => 'required|url',
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_notes' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $vendor = Vendor::findOrFail($validated['vendor_id']);

        // Validate vendor has email
        if (!$vendor->email) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vendor does not have an email address.'
            ], 422);
        }

        try {
            // Send email using Mail facade
            Mail::raw($validated['email_content'], function ($message) use ($vendor, $validated) {
                $message->to($vendor->email)
                    ->subject($validated['subject']);
            });

            // Log the payment details
            \Log::info('Contact Business Email Sent', [
                'vendor_id' => $vendor->id,
                'vendor_name' => $vendor->vendor_name,
                'vendor_email' => $vendor->email,
                'payment_amount' => $validated['payment_amount'],
                'payment_method' => $validated['payment_method'],
                'claim_link' => $validated['claim_link'],
                'sent_by' => auth()->user()?->email ?? 'unknown',
                'timestamp' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Email sent and payment recorded successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Contact Business Email Failed', [
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    // Generate claim token for vendor
    public function generateClaimToken(Vendor $vendor)
    {
        // Check if vendor has valid unclaimed status
        if (!$vendor->isUnclaimed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'This vendor has already been claimed.'
            ], 422);
        }

        try {
            // Generate claim token
            $token = $vendor->generateClaimToken();

            return response()->json([
                'status' => 'success',
                'token' => $token->token,
                'message' => 'Claim token generated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate token: ' . $e->getMessage()
            ], 500);
        }
    }
}
