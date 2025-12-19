@extends('layouts.vendor')

@section('page-title', 'Vendor Dashboard')

@section('content')
<div class="space-y-8">
    <!-- WELCOME BANNER -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Welcome, Vendor!</h1>
                <p class="text-indigo-100 mt-2">Manage your business, track bookings, and grow your presence</p>
            </div>
            <div class="text-6xl opacity-50">🎉</div>
        </div>
    </div>

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Bookings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    <p class="text-xs text-gray-400 mt-2">This month: 0</p>
                </div>
                <div class="text-4xl text-blue-100">📅</div>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Requests</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    <p class="text-xs text-gray-400 mt-2">Awaiting response</p>
                </div>
                <div class="text-4xl text-yellow-100">⏳</div>
            </div>
            <a href="#" class="mt-3 text-yellow-600 text-sm font-semibold hover:underline">Review → </a>
        </div>

        <!-- Total Reviews -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Reviews</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    <p class="text-xs text-gray-400 mt-2">Average Rating: 5.0 ⭐</p>
                </div>
                <div class="text-4xl text-green-100">⭐</div>
            </div>
        </div>

        <!-- Profile Status -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Profile Status</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">80%</p>
                    <p class="text-xs text-gray-400 mt-2">Complete your profile</p>
                </div>
                <div class="text-4xl text-purple-100">✓</div>
            </div>
            <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                <div class="bg-purple-500 h-2 rounded-full" style="width: 80%"></div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- RECENT BOOKINGS -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Bookings</h2>
                <a href="#" class="text-indigo-600 text-sm font-semibold hover:underline">View All →</a>
            </div>
            <div class="divide-y max-h-96 overflow-y-auto">
                <!-- No Bookings State -->
                <div class="px-6 py-12 text-center">
                    <div class="text-5xl mb-3">📭</div>
                    <p class="text-gray-500 font-medium">No bookings yet</p>
                    <p class="text-gray-400 text-sm mt-1">Your bookings will appear here</p>
                    <a href="#" class="mt-4 inline-block px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 text-sm font-semibold">
                        View Your Listings
                    </a>
                </div>

                <!-- Sample Booking Item (Hidden when no bookings) -->
                <div class="px-6 py-4 hover:bg-gray-50 hidden">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="font-semibold text-gray-900">Wedding - Ahmad & Fatimah</p>
                            <p class="text-sm text-gray-500 mt-1">📅 15 Jan 2024 • 👥 200 guests</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Confirmed</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <p class="text-gray-600">Package: Premium (5 hours)</p>
                        <p class="font-semibold text-gray-900">RM 3,500</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS & ALERTS -->
        <div class="space-y-6">
            <!-- QUICK ACTIONS -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg border-2 border-indigo-200 hover:bg-indigo-50 hover:border-indigo-400 transition">
                        <span class="text-2xl">📝</span>
                        <span class="text-sm font-semibold text-gray-700">Edit Profile</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg border-2 border-blue-200 hover:bg-blue-50 hover:border-blue-400 transition">
                        <span class="text-2xl">🖼️</span>
                        <span class="text-sm font-semibold text-gray-700">Manage Gallery</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg border-2 border-green-200 hover:bg-green-50 hover:border-green-400 transition">
                        <span class="text-2xl">💰</span>
                        <span class="text-sm font-semibold text-gray-700">Update Pricing</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg border-2 border-purple-200 hover:bg-purple-50 hover:border-purple-400 transition">
                        <span class="text-2xl">📊</span>
                        <span class="text-sm font-semibold text-gray-700">View Analytics</span>
                    </a>
                </div>
            </div>

            <!-- PROFILE COMPLETION ALERT -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">ℹ️</span>
                    <div>
                        <p class="font-semibold text-blue-900">Complete Your Profile</p>
                        <p class="text-sm text-blue-700 mt-1">Add a professional banner, update description, and upload more photos to attract more bookings!</p>
                        <a href="#" class="mt-2 text-blue-600 text-sm font-semibold hover:underline">Complete Now →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURES & ANALYTICS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- PERFORMANCE OVERVIEW -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Performance Metrics</h2>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Profile Views</span>
                        <span class="text-sm font-bold text-gray-900">0</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Booking Rate</span>
                        <span class="text-sm font-bold text-gray-900">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Response Time</span>
                        <span class="text-sm font-bold text-gray-900">N/A</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Customer Rating</span>
                        <span class="text-sm font-bold text-gray-900">5.0 ⭐</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HELPFUL TIPS -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">💡 Tips to Boost Your Business</h2>
            
            <ul class="space-y-3 text-sm">
                <li class="flex gap-3">
                    <span class="text-lg">✨</span>
                    <span class="text-gray-700"><strong>High-quality photos:</strong> Upload clear, professional images of your work</span>
                </li>
                <li class="flex gap-3">
                    <span class="text-lg">⚡</span>
                    <span class="text-gray-700"><strong>Quick response:</strong> Reply to booking inquiries within 24 hours</span>
                </li>
                <li class="flex gap-3">
                    <span class="text-lg">🎯</span>
                    <span class="text-gray-700"><strong>Detailed description:</strong> Write a compelling service description</span>
                </li>
                <li class="flex gap-3">
                    <span class="text-lg">🏆</span>
                    <span class="text-gray-700"><strong>Collect reviews:</strong> Ask customers to leave feedback after service</span>
                </li>
                <li class="flex gap-3">
                    <span class="text-lg">💬</span>
                    <span class="text-gray-700"><strong>Transparent pricing:</strong> Clearly list all package options & pricing</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- FEATURED SECTION -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg shadow p-6 border-2 border-orange-200">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-2">✨ Boost Your Visibility</h2>
                <p class="text-gray-700 mb-4">Feature your vendor profile to appear at the top of search results and get more bookings!</p>
                <div class="flex gap-2">
                    <a href="#" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-semibold text-sm">
                        Learn More
                    </a>
                    <a href="#" class="px-4 py-2 bg-white border-2 border-orange-500 text-orange-500 rounded-lg hover:bg-orange-50 font-semibold text-sm">
                        View Plans
                    </a>
                </div>
            </div>
            <div class="text-5xl opacity-50">⭐</div>
        </div>
    </div>
</div>
@endsection
