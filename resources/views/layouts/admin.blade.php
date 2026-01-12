<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Jom Kahwin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-100 min-h-screen flex">
    <div class="flex w-full h-screen">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-lg border-r border-pink-200 min-h-screen fixed left-0 top-0 flex flex-col justify-between transition-all duration-300 overflow-y-auto">

            <!-- TOP SECTION -->
            <div class="pt-6 px-6 pb-4 border-b border-pink-200">
                <h1 class="text-xl font-bold text-rose-700">Wedding Ease</h1>
                <p class="text-xs text-rose-500 font-semibold mt-1">ADMIN PANEL</p>
            </div>

            <!-- NAVIGATION -->
            <nav class="flex-1 px-4 space-y-1 mt-4">

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4m10-11v11a1 1 0 01-1 1h-4m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- VENDORS SECTION -->
                <div class="mt-4 pt-4 border-t border-pink-200 space-y-1">
                    <p class="px-4 py-2 text-xs font-bold text-rose-600 uppercase tracking-wide">Vendors</p>
                    
                    <a href="{{ route('admin.vendors.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.vendors.*') && !request()->routeIs('admin.ownership-requests.*') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>All Vendors</span>
                    </a>

                    <!-- <a href="{{ route('admin.ownership-requests.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition relative {{ request()->routeIs('admin.ownership-requests.*') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Ownership Requests</span>
                        @php
                            $pendingCount = \App\Models\VendorOwnershipRequest::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-rose-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a> -->
                </div>

                <!-- MANAGEMENT SECTION -->
                <div class="mt-4 pt-4 border-t border-pink-200 space-y-1">
                    <p class="px-4 py-2 text-xs font-bold text-rose-600 uppercase tracking-wide">Management</p>
                    
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM15 20H9v-2a6 6 0 0112 0v2z" />
                        </svg>
                        <span>Users</span>
                    </a>

                    <a href="{{ route('admin.bookings.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.bookings.*') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7 20H5a2 2 0 01-2-2V9a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2h-5l4 2v-2z" />
                        </svg>
                        <span>Bookings</span>
                    </a>
                </div>

                <!-- SETTINGS SECTION -->
                <!-- <div class="mt-4 pt-4 border-t border-pink-200 space-y-1">
                    <p class="px-4 py-2 text-xs font-bold text-rose-600 uppercase tracking-wide">Configuration</p>
                    
                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Settings</span>
                    </a>
                </div> -->

            </nav>

            <!-- LOGOUT SECTION -->
            <div class="p-4 border-t border-pink-200 bg-white mt-auto">
                <form method="POST" action="{{ route('logout') }}" class="inline-block w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-100 hover:text-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col overflow-hidden ml-64">

            <!-- HEADER -->
            <header style="background: linear-gradient(135deg, #ffe5d9 0%, #ffcad4 100%);" class="shadow-md px-8 py-6 border-b border-pink-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-rose-700">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-rose-600 mt-1">Welcome back, {{ auth()->user()->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-rose-700 font-semibold">{{ date('l, F j, Y') }}</p>
                    </div>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <div class="flex-1 overflow-auto bg-pink-100">
                <div class="p-8">

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg">
                            <p class="text-red-700 font-bold text-sm mb-2">⚠️ Errors:</p>
                            <ul class="text-red-600 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
                            <p class="text-green-700 font-semibold text-sm">✓ {{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg">
                            <p class="text-red-700 font-semibold text-sm">✗ {{ session('error') }}</p>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')

                </div>
            </div>

        </main>

