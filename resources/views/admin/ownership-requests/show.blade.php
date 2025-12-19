@extends('layouts.admin')

@section('page-title', 'Ownership Request Details')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.ownership-requests.index') }}" class="text-blue-600 hover:underline mb-6 inline-block">← Back to Requests</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- User Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">User Information</h3>
            <div class="space-y-3 text-gray-700">
                <p><strong>Name:</strong> {{ $request->user->name }}</p>
                <p><strong>Email:</strong> {{ $request->user->email }}</p>
                <p><strong>Phone:</strong> {{ $request->user->phone ?? '—' }}</p>
                <p><strong>Role:</strong> <span class="px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded">{{ ucfirst($request->user->role) }}</span></p>
            </div>
        </div>

        <!-- Vendor Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Vendor Information</h3>
            <div class="space-y-3 text-gray-700">
                <p><strong>Name:</strong> {{ $request->vendor->vendor_name }}</p>
                <p><strong>Category:</strong> {{ $request->vendor->category ?? '—' }}</p>
                <p><strong>Status:</strong> <span class="px-2 py-1 {{ $request->vendor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-sm rounded">{{ ucfirst($request->vendor->status) }}</span></p>
                <p><strong>Location:</strong> {{ $request->vendor->city }}, {{ $request->vendor->state }}</p>
            </div>
        </div>
    </div>

    <!-- Request Status -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Status</h3>
        <div class="space-y-3 text-gray-700">
            <p><strong>Status:</strong> <span class="px-2 py-1 {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }} text-sm rounded font-semibold">{{ ucfirst($request->status) }}</span></p>
            <p><strong>Requested:</strong> {{ $request->created_at->format('M d, Y H:i') }}</p>
            @if($request->reviewed_at)
                <p><strong>Reviewed:</strong> {{ $request->reviewed_at->format('M d, Y H:i') }}</p>
                <p><strong>Reviewed By:</strong> {{ $request->reviewer->name ?? '—' }}</p>
            @endif
            @if($request->rejection_reason)
                <p><strong>Rejection Reason:</strong> {{ $request->rejection_reason }}</p>
            @endif
        </div>
    </div>

    <!-- Actions -->
    @if($request->status === 'pending')
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
            <div class="flex gap-4">
                <form method="POST" action="{{ route('admin.ownership-requests.approve', $request->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">Approve Request</button>
                </form>
                <form method="POST" action="{{ route('admin.ownership-requests.reject', $request->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">Reject Request</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
