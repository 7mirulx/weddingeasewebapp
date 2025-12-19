@extends('layouts.admin')

@section('page-title', 'User Management')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Users Management</h2>
    <p class="text-gray-600 text-sm mt-1">Manage user accounts and access</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Joined</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-700 text-sm">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            @if($user->role === 'admin') bg-red-100 text-red-800
                            @elseif($user->role === 'vendor') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ ($user->is_active ?? true) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ($user->is_active ?? true) ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-orange-600 hover:text-orange-800 font-semibold">
                                    {{ ($user->is_active ?? true) ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
