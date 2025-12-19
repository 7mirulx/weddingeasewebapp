<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vendor Dashboard - Wedding Ease</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-indigo-50 min-h-screen flex">
    <div class="flex w-full h-screen">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-lg border-r border-indigo-200 min-h-screen fixed left-0 top-0 flex flex-col justify-between transition-all duration-300 overflow-y-auto">

            <!-- TOP SECTION -->
            <div class="pt-6 px-6 pb-4 border-b border-indigo-200">
            <h1 class="text-xl font-bold text-indigo-700">Wedding Ease</h1>
                <p class="text-xs text-indigo-500 font-semibold mt-1">VENDOR PANEL</p>
            </div>

            <!-- NAVIGATION -->
            <nav class="flex-1 px-4 space-y-1 mt-4">

                <!-- Dashboard -->
                <a href="{{ route('vendor.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.dashboard') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4m10-11v11a1 1 0 01-1 1h-4m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- BUSINESS SECTION -->
                <div class="mt-4 pt-4 border-t border-indigo-200 space-y-1">
                    <p class="px-4 py-2 text-xs font-bold text-indigo-600 uppercase tracking-wide">Business</p>
                    
                    <a href="{{ route('vendor.profile.edit') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.profile.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>My Profile</span>
                    </a>

                    <a href="{{ route('vendor.bookings.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.bookings.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7 20H5a2 2 0 01-2-2V9a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2h-5l4 2v-2z" />
                        </svg>
                        <span>Bookings</span>
                    </a>

                    <a href="{{ route('vendor.gallery.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.gallery.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Gallery</span>
                    </a>

                    <a href="{{ route('vendor.pricing.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.pricing.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Pricing</span>
                    </a>
                </div>

                <!-- ANALYTICS SECTION -->
                <div class="mt-4 pt-4 border-t border-indigo-200 space-y-1">
                    <p class="px-4 py-2 text-xs font-bold text-indigo-600 uppercase tracking-wide">Analytics</p>
                    
                    <a href="{{ route('vendor.reviews.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.reviews.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>Reviews</span>
                    </a>

                    <a href="{{ route('vendor.analytics') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.analytics') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Analytics</span>
                    </a>
                </div>

                <!-- ACCOUNT SECTION -->
                <div class="mt-4 pt-4 border-t border-indigo-200 space-y-1">
                    <p class="px-4 py-2 text-xs font-bold text-indigo-600 uppercase tracking-wide">Account</p>
                    
                    <a href="{{ route('vendor.settings') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.settings') ? 'bg-indigo-200 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Settings</span>
                    </a>
                </div>

            </nav>

            <!-- LOGOUT SECTION -->
            <div class="p-4 border-t border-indigo-200 bg-white mt-auto">
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
            <header style="background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);" class="shadow-md px-8 py-6 border-b border-indigo-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-indigo-700">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-indigo-600 mt-1">Welcome back, {{ auth()->user()->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-indigo-700 font-semibold">{{ date('l, F j, Y') }}</p>
                    </div>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <div class="flex-1 overflow-auto bg-indigo-50">
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

    </div>
</body>
</html>
