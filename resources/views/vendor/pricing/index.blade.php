@extends('layouts.vendor')

@section('page-title', 'Pricing')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">Pricing Management</h2>

        <form action="{{ route('vendor.pricing.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Starting Price -->
            <div>
                <label for="starting_price" class="block text-sm font-semibold text-gray-700 mb-2">Starting Price (RM) *</label>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2">RM</span>
                    <input type="number" 
                        id="starting_price" 
                        name="starting_price" 
                        step="0.01"
                        min="0"
                        value="{{ old('starting_price', $vendor->starting_price) }}" 
                        required
                        placeholder="0.00"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <p class="text-sm text-gray-600 mt-2">This is your base/starting price for clients to know your range</p>
                @error('starting_price')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Info Box -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">Pricing Tips</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Set a competitive starting price for your services</li>
                    <li>• You can adjust the agreed price per booking based on client requirements</li>
                    <li>• Be transparent about your pricing to attract quality clients</li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Save Pricing
                </button>
                <a href="{{ route('vendor.dashboard') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
