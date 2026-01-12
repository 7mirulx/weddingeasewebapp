@extends('layouts.admin')

@section('page-title', 'Booking Details')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-md mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Bookings
    </a>

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
            <div class="space-y-3">
                @php
                    $paymentProgress = is_string($booking->payment_progress) 
                        ? json_decode($booking->payment_progress, true) 
                        : $booking->payment_progress;
                @endphp
                @if(is_array($paymentProgress) && count($paymentProgress) > 0)
                    @foreach($paymentProgress as $index => $payment)
                        <div class="border-l-4 border-blue-500 pl-4 py-2 bg-gray-50 rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800">Payment #{{ $loop->iteration }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $payment['notes'] ?? 'No notes' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-blue-600">RM {{ number_format($payment['amount'] ?? 0, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment['date'] ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="pt-3 border-t border-gray-200 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-800">Total Paid:</span>
                            <span class="font-bold text-green-600 text-lg">
                                RM {{ number_format(array_sum(array_column($paymentProgress, 'amount')), 2) }}
                            </span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No payment records yet</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
