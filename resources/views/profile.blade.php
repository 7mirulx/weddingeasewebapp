@extends('layouts.userapp')

@section('page-title', 'My Profile')

@section('content')

@php
    $user = auth()->user();
    $wedding = $user->weddingDetails;
@endphp

<div class="max-w-6xl mx-auto py-8">
    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transition.opacity.duration.500ms
        class="fixed inset-0 flex items-center justify-center z-[9999]"
    >
        <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>
        <div class="bg-white w-full max-w-md mx-auto rounded-xl shadow-2xl z-[99999] p-6 border-l-4 border-green-500">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">Success</h3>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">✖</button>
            </div>
            <p class="text-sm text-gray-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-rose-700 mb-2">My Profile</h1>
        <p class="text-gray-600 text-lg">Manage your account and wedding details</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- SIDEBAR --}}
        <!-- <div class="lg:col-span-1">
            {{-- PROFILE CARD --}}
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border-2 border-pink-200 rounded-2xl p-6 shadow-sm sticky top-8">
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-rose-400 to-pink-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-rose-700 mb-1">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600 mb-4">{{ $user->email }}</p>
                    
                    @if($wedding)
                    <div class="bg-white rounded-lg p-3 mb-4 border border-pink-200">
                        <p class="text-xs text-gray-500 mb-1">Wedding Date</p>
                        <p class="text-sm font-semibold text-rose-700">{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div> -->

        {{-- MAIN CONTENT --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- USER PROFILE SECTION --}}
            <div class="bg-white border-2 border-pink-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-pink-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-rose-700">Account Information</h2>
                </div>

                <form action="{{ url('/profile/update') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                            placeholder="Your full name">
                    </div>

                    {{-- Email (Read-only) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full border-2 border-gray-300 rounded-lg p-3 bg-gray-50 text-gray-600 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ $user->phone }}"
                            class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                            placeholder="Your phone number">
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold rounded-lg transition shadow-md">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            {{-- WEDDING DETAILS SECTION --}}
            <div class="bg-white border-2 border-pink-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-pink-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-rose-700">Wedding Details</h2>
                </div>

                @if(!$wedding)
                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-6 text-center">
                        <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m0 0h6m-6-6H6m0 0H0" />
                        </svg>
                        <p class="text-gray-700 mb-4 font-semibold">You haven't set up your wedding details yet</p>
                        <p class="text-gray-600 text-sm mb-6">Set up your wedding information to start organizing your ceremony</p>
                        <a href="{{ url('/wedding/setup') }}"
                            class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-lg transition shadow-md">
                            + Setup Wedding Details
                        </a>
                    </div>

                @else
                    <form action="{{ url('/profile/wedding') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Row 1: Partner Name & Wedding Date --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Partner's Name</label>
                                <input type="text" name="partner_name"
                                    value="{{ $wedding->partner_name }}"
                                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                                    placeholder="Partner's name">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Wedding Date</label>
                                <input type="date" name="wedding_date"
                                    value="{{ $wedding->wedding_date }}"
                                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition">
                            </div>
                        </div>

                        {{-- Row 2: Wedding Theme & Wedding Size --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Wedding Theme</label>
                                <input type="text" name="wedding_theme"
                                    value="{{ $wedding->wedding_theme }}"
                                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                                    placeholder="e.g., Modern, Traditional, Rustic">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Guest Count (pax)</label>
                                <input type="number" name="wedding_size"
                                    value="{{ $wedding->wedding_size }}"
                                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                                    placeholder="Number of guests">
                            </div>
                        </div>

                        {{-- Row 3: Budget & Venue State --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Budget (RM)</label>
                                <input type="number" name="budget"
                                    value="{{ $wedding->budget }}"
                                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                                    placeholder="Budget in RM">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Venue State</label>
                                <input type="text" name="venue_state"
                                    value="{{ $wedding->venue_state }}"
                                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                                    placeholder="State/Region">
                            </div>
                        </div>

                        {{-- Preference Priority --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Preference Priority</label>
                            <select name="preference_priority"
                                class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition">
                                <option value="balanced" {{ $wedding->preference_priority=='balanced'?'selected':'' }}>⚖️ Balanced - Mix of quality and budget</option>
                                <option value="budget" {{ $wedding->preference_priority=='budget'?'selected':'' }}>💰 Budget-Friendly - Cost-effective options</option>
                                <option value="quality" {{ $wedding->preference_priority=='quality'?'selected':'' }}>✨ High Quality - Premium services</option>
                                <option value="service" {{ $wedding->preference_priority=='service'?'selected':'' }}>🎯 Best Service - Excellent customer care</option>
                                <option value="popularity" {{ $wedding->preference_priority=='popularity'?'selected':'' }}>⭐ Popular Vendors - Highly rated</option>
                            </select>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end pt-4 border-t-2 border-pink-200">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold rounded-lg transition shadow-md">
                                Save Wedding Details
                            </button>
                        </div>
                    </form>

                    {{-- Wedding Info Cards --}}
                    <div class="mt-8 pt-8 border-t-2 border-pink-200">
                        <h3 class="text-lg font-bold text-rose-700 mb-4">Wedding Summary</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Partner</p>
                                <p class="font-semibold text-rose-700">{{ $wedding->partner_name }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Wedding Date</p>
                                <p class="font-semibold text-rose-700">{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('M d, Y') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Guests</p>
                                <p class="font-semibold text-rose-700">{{ $wedding->wedding_size ?? 'Not set' }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Budget</p>
                                <p class="font-semibold text-rose-700">RM {{ number_format($wedding->budget ?? 0, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Theme</p>
                                <p class="font-semibold text-rose-700">{{ $wedding->wedding_theme ?? 'Not set' }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Location</p>
                                <p class="font-semibold text-rose-700">{{ $wedding->venue_state ?? 'Not set' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

</div>

@endsection
