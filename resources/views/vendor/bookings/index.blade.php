@extends('layouts.vendor')

@section('page-title', 'Client Bookings')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Total Bookings</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $bookings->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Completed</p>
            <p class="text-3xl font-bold text-green-600">{{ $bookings->where('status', 'completed')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Pending</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $bookings->whereIn('status', ['prospect', 'contacted', 'ready'])->count() }}</p>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-indigo-700">Bookings</h3>
        </div>
        
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-700">Client Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-700">WhatsApp</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-700">Agreed Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-700">Days to Wedding</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->user->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->user->phone) }}" 
                                           target="_blank"
                                           class="text-green-600 hover:text-green-700 font-semibold">
                                            {{ $booking->user->phone }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('vendor.bookings.update-status', $booking) }}" method="POST" class="inline-flex gap-2">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()"
                                            class="px-3 py-1 text-sm rounded-lg border 
                                            @if($booking->status === 'prospect') border-gray-400 bg-gray-100
                                            @elseif($booking->status === 'contacted') border-blue-400 bg-blue-50
                                            @elseif($booking->status === 'ready') border-yellow-400 bg-yellow-50
                                            @elseif($booking->status === 'completed') border-green-400 bg-green-50
                                            @endif">
                                            <option value="prospect" {{ $booking->status === 'prospect' ? 'selected' : '' }}>Prospect</option>
                                            <option value="contacted" {{ $booking->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="ready" {{ $booking->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('vendor.bookings.update-price', $booking) }}" method="POST" class="inline-flex gap-2">
                                        @csrf
                                        <input type="number" 
                                            name="agreed_price" 
                                            step="0.01"
                                            value="{{ $booking->agreed_price ?? '' }}"
                                            placeholder="RM 0.00"
                                            class="w-32 px-2 py-1 text-sm border border-gray-300 rounded">
                                        <button type="submit" class="px-3 py-1 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                            Set
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->days_until_wedding !== null)
                                        <div class="text-center">
                                            @if($booking->days_until_wedding > 0)
                                                <p class="font-bold text-indigo-600">{{ $booking->days_until_wedding }}</p>
                                                <p class="text-xs text-gray-600">days left</p>
                                            @elseif($booking->days_until_wedding == 0)
                                                <p class="font-bold text-red-600">TODAY!</p>
                                            @else
                                                <p class="text-xs text-gray-500">Wedding passed</p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500">No date</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->user->phone) }}" 
                                       target="_blank"
                                       class="inline-block px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                        Contact via WhatsApp
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center">
                <p class="text-gray-500 text-lg">No bookings yet</p>
                <p class="text-gray-400 text-sm mt-2">Your bookings will appear here when clients book your services</p>
            </div>
        @endif
    </div>
</div>
@endsection
