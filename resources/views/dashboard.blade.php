@php
    $firstName = explode(' ', trim(auth()->user()->name))[0];
    $wedding = auth()->user()->weddingDetails;
@endphp

@extends('layouts.userapp')

@section('content')
<div>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10">

        <h1 class="text-3xl font-bold text-rose-900">
            Welcome, {{ $firstName }} 👋
        </h1>

        {{-- If user does NOT have wedding details --}}
        {{-- Success Modal --}}
        @if(session('success'))
            <div id="successModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                
                <div class="bg-white w-80 p-6 rounded-2xl shadow-xl text-center animate-fade">
                    
                    <h2 class="text-xl font-bold text-rose-700 mb-2">Saved! 🎉</h2>
                    <p class="text-gray-600 mb-5">
                        Your wedding details have been updated successfully.
                    </p>

                    <button 
                        onclick="document.getElementById('successModal').remove()"
                        class="px-6 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                        OK
                    </button>
                </div>

            </div>
        @endif

        @if(!$wedding)
            <div class="mt-10 bg-white p-8 rounded-xl shadow">
                <h2 class="text-2xl font-semibold text-rose-900 mb-4">
                    Let's Get Started 💍
                </h2>

                <p class="text-gray-700 mb-6">
                    We need a bit of information to personalize your wedding dashboard.
                </p>

                <a href="{{ url('/wedding/setup') }}"
                    class="inline-block px-6 py-3 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                    Setup Wedding Details
                </a>
            </div>

        @else
        {{-- If user ALREADY has wedding details → show real dashboard --}}
        
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold text-rose-900">Your Bookings</h3>
                    <p class="text-3xl font-bold mt-2">3</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold text-rose-900">Pending Payments</h3>
                    <p class="text-3xl font-bold mt-2">RM0</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold text-rose-900">Messages</h3>
                    <p class="text-3xl font-bold mt-2">1</p>
                </div>
            </div>

            <!-- Activities Table -->
            <div class="bg-white p-6 rounded-xl shadow mt-10">
                <h2 class="text-xl font-semibold text-rose-900 mb-4">Recent Activities</h2>

                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3">Activity</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr class="border-b">
                            <td class="py-3">Booked Wedding Package</td>
                            <td class="py-3">Nov 28, 2025</td>
                            <td class="py-3 text-green-600 font-medium">Completed</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3">Updated Profile Info</td>
                            <td class="py-3">Nov 15, 2025</td>
                            <td class="py-3 text-blue-600 font-medium">Updated</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        @endif

    </main>
</div>
@endsection
