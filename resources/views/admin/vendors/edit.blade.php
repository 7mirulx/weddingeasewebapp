@extends('layouts.admin')

@section('page-title', 'Edit Vendor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Vendor</h2>

        <form method="POST" action="{{ route('admin.vendors.update', $vendor->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Vendor Name *</label>
                <input type="text" name="vendor_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('vendor_name', $vendor->vendor_name) }}">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                <input type="text" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('category', $vendor->category) }}">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">{{ old('description', $vendor->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('email', $vendor->email) }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                    <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('phone', $vendor->phone) }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Starting Price</label>
                <input type="number" name="starting_price" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('starting_price', $vendor->starting_price) }}">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                    <input type="text" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('city', $vendor->city) }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                    <input type="text" name="state" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('state', $vendor->state) }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                    <input type="text" name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ old('address', $vendor->address) }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                    <option value="active" {{ old('status', $vendor->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $vendor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ old('status', $vendor->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $vendor->is_featured) ? 'checked' : '' }} class="rounded">
                <label for="is_featured" class="ml-2 text-gray-700">Mark as Featured Vendor</label>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.vendors.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 font-semibold">Update Vendor</button>
            </div>

            <!-- Send Claim Invite -->
            @if($vendor->isUnclaimed())
                <div class="mt-8 pt-8 border-t">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Send Claim Invitation</h3>
                    
                    @if(!$vendor->email)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <p class="text-yellow-800 font-semibold">⚠️ Email Address Required</p>
                            <p class="text-yellow-700 text-sm mt-1">
                                Please add the vendor's contact email address above before sending the claim invitation.
                            </p>
                        </div>
                        <button type="button" disabled class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-semibold opacity-50">
                            📧 Send Claim Invitation Email (Email Required)
                        </button>
                    @else
                        <p class="text-gray-600 mb-4">
                            This vendor has not claimed their account yet. Send them an invitation email with a secure claim link (valid for 24 hours).
                        </p>
                        <form method="POST" action="{{ route('admin.vendors.send-claim-invite', $vendor->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-semibold">
                                📧 Send Claim Invitation Email
                            </button>
                        </form>
                    @endif
                </div>
            @elseif($vendor->owner_user_id)
                <div class="mt-8 pt-8 border-t bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">✅ Vendor Claimed</h3>
                    <p class="text-green-700">
                        This vendor has been claimed by <strong>{{ $vendor->owner->name ?? 'Unknown' }}</strong>
                        on {{ $vendor->claimed_at?->format('M d, Y') ?? 'N/A' }}
                    </p>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
