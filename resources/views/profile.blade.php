@extends('layouts.userapp')

@section('content')

@php
    $user = auth()->user();
    $wedding = $user->weddingDetails;
@endphp

<div class="max-w-5xl mx-auto space-y-14">  {{-- 💡 spacing besar antara sections --}}

    <!-- SUCCESS MODAL -->
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white w-80 p-6 rounded-2xl shadow-xl text-center animate-fade">
                <h2 class="text-xl font-bold text-rose-700 mb-2">Success 🎉</h2>
                <p class="text-gray-600 mb-5">{{ session('success') }}</p>

                <button onclick="document.getElementById('successModal').remove()"
                    class="px-6 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                    OK
                </button>
            </div>
        </div>
    @endif


    <!-- USER PROFILE -->
    <!-- USER PROFILE -->
    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-rose-900 mb-6">User Profile</h2>

        <form action="{{ url('/profile/update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Row 1: Name + Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-1">
                    <label class="block text-sm text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full p-2 border rounded-lg text-sm">
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled
                        class="w-full p-2 border rounded-lg bg-gray-100 text-sm">
                </div>

            </div>

            <!-- Row 2: Phone (full width) -->
            <div>
                <label class="block text-sm text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}"
                    class="w-full p-2 border rounded-lg text-sm">
            </div>

            <!-- Save button -->
            <div class="flex justify-end mt-6">
                <button class="px-6 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-rose-600">
                    Save
                </button>
            </div>

        </form>
    </div>


    <!-- WEDDING DETAILS -->
    <div class="bg-white p-8 rounded-xl shadow max-w-4xl mt-10">
        <h2 class="text-xl font-semibold text-rose-900 mb-6">Wedding Details</h2>

        @if(!$wedding)
            <p class="text-gray-600 mb-4">
                You haven't set up your wedding details yet.
            </p>
            <a href="{{ url('/wedding/setup') }}"
                class="inline-block px-5 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700">
                Setup Wedding Details
            </a>

        @else
            <form action="{{ url('/profile/wedding') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Partner Name --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Partner Name</label>
                        <input type="text" name="partner_name"
                            value="{{ $wedding->partner_name }}"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Wedding Date --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Wedding Date</label>
                        <input type="date" name="wedding_date"
                            value="{{ $wedding->wedding_date }}"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Preference Priority --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1">Preference Priority</label>
                        <select name="preference_priority"
                            class="w-full p-2 border rounded-lg text-sm">
                            <option value="balanced" {{ $wedding->preference_priority=='balanced'?'selected':'' }}>Balanced</option>
                            <option value="budget" {{ $wedding->preference_priority=='budget'?'selected':'' }}>Budget-Friendly</option>
                            <option value="quality" {{ $wedding->preference_priority=='quality'?'selected':'' }}>High Quality</option>
                            <option value="service" {{ $wedding->preference_priority=='service'?'selected':'' }}>Best Service</option>
                            <option value="popularity" {{ $wedding->preference_priority=='popularity'?'selected':'' }}>Popular Vendors</option>
                        </select>
                    </div>

                    {{-- Wedding Theme --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Wedding Theme</label>
                        <input type="text" name="wedding_theme"
                            value="{{ $wedding->wedding_theme }}"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Wedding Size --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Wedding Size (pax)</label>
                        <input type="number" name="wedding_size"
                            value="{{ $wedding->wedding_size }}"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Budget --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Budget (RM)</label>
                        <input type="number" name="budget"
                            value="{{ $wedding->budget }}"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Venue State --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Venue State</label>
                        <input type="text" name="venue_state"
                            value="{{ $wedding->venue_state }}"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button class="px-6 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-rose-600">
                        Save
                    </button>
                </div>

            </form>
        @endif
    </div>


</div>

@endsection
