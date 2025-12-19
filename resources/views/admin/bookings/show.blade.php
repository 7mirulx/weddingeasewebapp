@extends('layouts.admin')

@section('page-title', 'Booking Details')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:underline mb-6 inline-block">← Back to Bookings</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Customer Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
            <div class="space-y-3 text-gray-700">
                <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                <p><strong>Phone:</strong> {{ $booking->user->phone ?? '—' }}</p>
            </div>
        </div>

        <!-- Vendor Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Vendor Information</h3>
            <div class="space-y-3 text-gray-700">
                <p><strong>Name:</strong> {{ $booking->vendor->vendor_name }}</p>
                <p><strong>Category:</strong> {{ $booking->vendor->category ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $booking->vendor->email ?? '—' }}</p>
                <p><strong>Phone:</strong> {{ $booking->vendor->phone ?? '—' }}</p>
            </div>
        </div>
    </div>

    <!-- Booking Details -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h3>
        <div class="space-y-3 text-gray-700">
            <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
            <p><strong>Status:</strong> <span class="px-2 py-1 text-xs font-semibold rounded {{ $booking->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $booking->is_completed ? 'Completed' : 'Pending' }}</span></p>
            <p><strong>Booked:</strong> {{ $booking->created_at->format('M d, Y H:i') }}</p>
            <p><strong>Updated:</strong> {{ $booking->updated_at->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <!-- Payment Progress -->
    @if($booking->payment_progress)
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Progress</h3>
            <div class="space-y-2 text-gray-700">
                @foreach($booking->payment_progress as $key => $amount)
                    <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                        @if($amount) RM {{ number_format($amount, 2) }}
                        @else <span class="text-gray-400">Pending</span>
                        @endif
                    </p>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
