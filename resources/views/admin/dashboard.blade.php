@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Vendors -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Vendors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalVendors }}</p>
                </div>
                <div class="text-4xl text-blue-100">📦</div>
            </div>
        </div>

        <!-- Pending Ownership Requests -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Requests</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $pendingRequests }}</p>
                </div>
                <div class="text-4xl text-orange-100">📋</div>
            </div>
            @if($pendingRequests > 0)
                <a href="{{ route('admin.ownership-requests.index') }}" class="mt-3 text-orange-600 text-sm font-semibold hover:underline">
                    Review Now →
                </a>
            @endif
        </div>

        <!-- Total Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Bookings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBookings }}</p>
                </div>
                <div class="text-4xl text-green-100">📅</div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="text-4xl text-purple-100">👥</div>
            </div>
        </div>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Vendors -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Vendors</h2>
            </div>
            <div class="divide-y">
                @php
                    $recentVendors = \App\Models\Vendor::latest('created_at')->limit(5)->get();
                @endphp
                @forelse($recentVendors as $vendor)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $vendor->vendor_name }}</p>
                                <p class="text-sm text-gray-500">{{ $vendor->category }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $vendor->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($vendor->status === 'active') bg-green-100 text-green-800
                                @elseif($vendor->status === 'inactive') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($vendor->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No vendors yet
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Ownership Requests -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Ownership Requests</h2>
            </div>
            <div class="divide-y">
                @php
                    $recentRequests = \App\Models\VendorOwnershipRequest::latest('requested_at')->limit(5)->get();
                @endphp
                @forelse($recentRequests as $request)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $request->vendor->vendor_name }}</p>
                                <p class="text-sm text-gray-500">by {{ $request->user->name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $request->requested_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($request->status === 'pending') bg-orange-100 text-orange-800
                                @elseif($request->status === 'approved') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No ownership requests yet
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.vendors.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-semibold text-sm">
                + Create Vendor
            </a>
            <a href="{{ route('admin.ownership-requests.index') }}" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-semibold text-sm">
                📋 Review Requests
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 font-semibold text-sm">
                👥 Manage Users
            </a>
            <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold text-sm">
                ⚙️ Settings
            </a>
        </div>
    </div>
</div>
@endsection
