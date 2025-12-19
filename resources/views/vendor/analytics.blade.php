@extends('layouts.vendor')

@section('page-title', 'Analytics')

@section('content')
<div class="space-y-6">
    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <p class="text-gray-600 text-sm mb-2">Total Bookings</p>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalBookings }}</p>
            <p class="text-xs text-gray-500 mt-3">All time</p>
        </div>

        <!-- Completed Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm mb-2">Completed</p>
            <p class="text-4xl font-bold text-green-600">{{ $completedBookings }}</p>
            <p class="text-xs text-gray-500 mt-3">{{ $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100) : 0 }}% completion rate</p>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <p class="text-gray-600 text-sm mb-2">Pending</p>
            <p class="text-4xl font-bold text-yellow-600">{{ $pendingBookings }}</p>
            <p class="text-xs text-gray-500 mt-3">Awaiting action</p>
        </div>

        <!-- Average Rating -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm mb-2">Avg Rating</p>
            <p class="text-4xl font-bold text-purple-600">{{ number_format($averageRating, 1) }}</p>
            <p class="text-xs text-gray-500 mt-3">From {{ $totalRatings }} reviews</p>
        </div>
    </div>

    <!-- Booking Status Breakdown -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-xl font-bold text-indigo-700 mb-6">Booking Status Overview</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Status Distribution -->
            <div>
                <h3 class="font-semibold text-gray-700 mb-4">Distribution</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700">Prospect</span>
                            <span class="font-semibold text-gray-900">{{ $pendingBookings }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-500 h-2 rounded-full" style="width: {{ $totalBookings > 0 ? ($pendingBookings / $totalBookings) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700">Completed</span>
                            <span class="font-semibold text-gray-900">{{ $completedBookings }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalBookings > 0 ? ($completedBookings / $totalBookings) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Tips -->
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                <h3 class="font-semibold text-blue-900 mb-4">Performance Tips</h3>
                <ul class="space-y-3 text-sm text-blue-800">
                    <li class="flex gap-2">
                        <span class="text-blue-600 mt-1">✓</span>
                        <span>Respond to bookings quickly to increase conversion</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 mt-1">✓</span>
                        <span>Update client status regularly to show progress</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 mt-1">✓</span>
                        <span>Ask clients to leave reviews after completing service</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 mt-1">✓</span>
                        <span>Maintain high quality service to get positive ratings</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-xl font-bold text-indigo-700 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('vendor.bookings.index') }}" class="p-4 border border-indigo-300 rounded-lg hover:bg-indigo-50 transition">
                <p class="font-semibold text-indigo-700">Manage Bookings</p>
                <p class="text-sm text-gray-600 mt-1">Update status and prices</p>
            </a>
            <a href="{{ route('vendor.reviews.index') }}" class="p-4 border border-purple-300 rounded-lg hover:bg-purple-50 transition">
                <p class="font-semibold text-purple-700">View Reviews</p>
                <p class="text-sm text-gray-600 mt-1">See client feedback</p>
            </a>
            <a href="{{ route('vendor.profile.edit') }}" class="p-4 border border-blue-300 rounded-lg hover:bg-blue-50 transition">
                <p class="font-semibold text-blue-700">Edit Profile</p>
                <p class="text-sm text-gray-600 mt-1">Update business information</p>
            </a>
        </div>
    </div>
</div>
@endsection
