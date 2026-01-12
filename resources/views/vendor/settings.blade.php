@extends('layouts.vendor')

@section('page-title', 'Settings')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">Account Settings</h2>

        <!-- Account Information Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Account Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vendor Name</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $vendor->vendor_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vendor Owner</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $vendor->owner->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $vendor->category ?? 'Not set' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg">
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold 
                            @if($vendor->status === 'active') bg-green-100 text-green-800
                            @elseif($vendor->status === 'inactive') bg-gray-100 text-gray-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Member Since</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $vendor->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Business Information Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Business Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $vendor->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $vendor->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">
                        {{ $vendor->city ?? 'N/A' }}{{ $vendor->state ? ', ' . $vendor->state : '' }}
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('vendor.profile.edit') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Edit Business Info
                </a>
            </div>
        </div>

        <!-- Privacy & Security Section -->
        <!-- <div class="mb-8 pb-8 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Privacy & Security</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">Two-Factor Authentication</p>
                        <p class="text-sm text-gray-600">Secure your account with 2FA</p>
                    </div>
                    <button type="button" disabled class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg text-sm cursor-not-allowed">
                        Coming Soon
                    </button>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">Change Password</p>
                        <p class="text-sm text-gray-600">Update your account password</p>
                    </div>
                    <button type="button" disabled class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg text-sm cursor-not-allowed">
                        Coming Soon
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Notification Preferences Section -->
        <!-- <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Notification Preferences</h3>
            <div class="space-y-4">
                <label class="flex items-center p-4 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                    <input type="checkbox" class="w-4 h-4 rounded" disabled checked>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Email Notifications</p>
                        <p class="text-sm text-gray-600">Receive emails for new bookings</p>
                    </div>
                </label>
                <label class="flex items-center p-4 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                    <input type="checkbox" class="w-4 h-4 rounded" disabled checked>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Booking Alerts</p>
                        <p class="text-sm text-gray-600">Get notified of new bookings</p>
                    </div>
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-4">Notification settings management coming soon</p>
        </div> -->

        <!-- Help & Support -->
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="font-semibold text-blue-900 mb-2">Need Help?</h3>
            <p class="text-sm text-blue-800 mb-3">For support or questions about your account, please contact our support team.</p>
            <a href="mailto:support@weddingease.com" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
