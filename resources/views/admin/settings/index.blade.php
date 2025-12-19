@extends('layouts.admin')

@section('page-title', 'Settings')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Platform Settings</h2>
    <p class="text-gray-600 text-sm mt-1">Manage vendor categories and email configuration</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Vendor Categories -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Vendor Categories</h3>
        <form method="POST" action="{{ route('admin.settings.categories') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Categories (comma-separated)</label>
                <textarea name="categories" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" placeholder="Photography, Catering, Venue, Decoration, Music, ...">{{ $vendorCategories ? implode(', ', json_decode($vendorCategories->value, true)) : '' }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Enter one category per line or separated by commas</p>
            </div>
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 font-semibold">Save Categories</button>
        </form>
    </div>

    <!-- Email Sender Configuration -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Email Sender Information</h3>
        <form method="POST" action="{{ route('admin.settings.email-sender') }}" class="space-y-4">
            @csrf
            @php
                $emailSender = $emailSender ? json_decode($emailSender->value, true) : ['sender_name' => '', 'sender_email' => ''];
            @endphp
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sender Name</label>
                <input type="text" name="sender_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ $emailSender['sender_name'] ?? 'Jom Kahwin' }}" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sender Email</label>
                <input type="email" name="sender_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" value="{{ $emailSender['sender_email'] ?? '' }}" required>
            </div>

            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 font-semibold">Save Email Settings</button>
        </form>
    </div>
</div>

<!-- System Information -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">System Information</h3>
    <div class="space-y-3 text-gray-700 text-sm">
        <p><strong>Platform:</strong> Jom Kahwin Wedding Marketplace</p>
        <p><strong>Admin Panel Version:</strong> 1.0.0</p>
        <p><strong>Framework:</strong> Laravel 11</p>
        <p><strong>Last Updated:</strong> {{ now()->format('M d, Y H:i') }}</p>
    </div>
</div>
@endsection
