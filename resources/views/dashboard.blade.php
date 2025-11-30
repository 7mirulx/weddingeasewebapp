@php
    $firstName = explode(' ', trim(auth()->user()->name))[0];
@endphp

@extends('layouts.userapp')

@section('content')
<div class="flex min-h-screen bg-pink-100">
    <!-- Sidebar imporrted from userapp layout -->
    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10">

        <h1 class="text-3xl font-bold text-rose-900">
            Welcome, {{ $firstName }} 👋
        </h1>

       

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

    </main>
</div>
@endsection
