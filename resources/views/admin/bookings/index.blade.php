@extends('layouts.admin')

@section('page-title', 'Bookings Management')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Bookings Management</h2>
    <p class="text-gray-600 text-sm mt-1">View all customer bookings</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Booking ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Vendor</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">#{{ $booking->id }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->user->email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $booking->vendor->vendor_name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->vendor->category }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $booking->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $booking->is_completed ? 'Completed' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $booking->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600 hover:underline">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $bookings->links() }}
</div>
@endsection
