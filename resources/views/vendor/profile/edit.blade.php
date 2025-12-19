@extends('layouts.vendor')

@section('page-title', 'My Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">Edit Business Profile</h2>

        <form action="{{ route('vendor.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Vendor Name -->
            <div>
                <label for="vendor_name" class="block text-sm font-semibold text-gray-700 mb-2">Business Name *</label>
                <input type="text" 
                    id="vendor_name" 
                    name="vendor_name" 
                    value="{{ old('vendor_name', $vendor->vendor_name) }}" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('vendor_name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description', $vendor->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                <input type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone', $vendor->phone) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('phone')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $vendor->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Full Address</label>
                <input type="text" 
                    id="address" 
                    name="address" 
                    value="{{ old('address', $vendor->address) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('address')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                <input type="text" 
                    id="city" 
                    name="city" 
                    value="{{ old('city', $vendor->city) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('city')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- State -->
            <div>
                <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                <input type="text" 
                    id="state" 
                    name="state" 
                    value="{{ old('state', $vendor->state) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('state')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Postcode -->
            <div>
                <label for="postcode" class="block text-sm font-semibold text-gray-700 mb-2">Postcode</label>
                <input type="text" 
                    id="postcode" 
                    name="postcode" 
                    value="{{ old('postcode', $vendor->postcode) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('postcode')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Services -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Services You Provide *</label>
                <p class="text-sm text-gray-600 mb-4">Select all services that apply to your business</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $categories = config('vendor_categories');
                        $selectedServices = old('service_ids', $vendor->service_ids ?? []);
                    @endphp
                    
                    @foreach($categories as $id => $name)
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-indigo-50 transition">
                            <input type="checkbox" 
                                name="service_ids[]" 
                                value="{{ $id }}"
                                {{ in_array($id, (array)$selectedServices) ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                            <span class="ml-3 text-gray-700">{{ $name }}</span>
                        </label>
                    @endforeach
                </div>

                @error('service_ids')
                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Save Changes
                </button>
                <a href="{{ route('vendor.dashboard') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
