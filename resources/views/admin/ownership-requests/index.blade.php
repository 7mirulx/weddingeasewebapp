@extends('layouts.admin')

@section('page-title', 'Ownership Requests')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Vendor Ownership Requests</h2>
    <p class="text-gray-600 text-sm mt-1">Review and approve/reject vendor ownership requests</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Vendor</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Requested</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $request->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $request->user->email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $request->vendor->vendor_name }}</p>
                        <p class="text-xs text-gray-500">ID: {{ $request->vendor->id }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($request->status === 'approved') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $request->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($request->status === 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('admin.ownership-requests.approve', $request->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.ownership-requests.reject', $request->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Reject</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('admin.ownership-requests.show', $request->id) }}" class="text-blue-600 hover:underline">View</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No ownership requests</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $requests->links() }}
</div>
@endsection
