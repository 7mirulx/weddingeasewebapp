<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'WeddingEase') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-white shadow-lg border-r border-pink-200 min-h-screen fixed left-0 top-0 flex flex-col justify-between transition-all duration-300 overflow-y-auto">

        <!-- TOP SECTION -->
        <div class="pt-6 px-6 pb-4 border-b border-pink-200">
            <h1 class="text-xl font-bold text-rose-700">Jom Kahwin</h1>
            <p class="text-xs text-rose-500 font-semibold mt-1">USER DASHBOARD</p>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 px-4 space-y-1 mt-4">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-pink-200 text-rose-700 font-semibold' : 'text-gray-700 hover:bg-pink-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4m10-11v11a1 1 0 01-1 1h-4m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/preweddingpreparation') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-gray-700 hover:bg-pink-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-rose-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m2-3.5V18a2 2 0 01-2 2H9a2 2 0 01-2-2V6.5A2.5 2.5 0 019.5 4h5A2.5 2.5 0 0117 6.5z" />
                </svg>
                <span>Pre Wedding Preparation</span>
            </a>
            <!-- WEDDING PLANNER SUBMENU -->
            <div x-data="{ open: false }" class="space-y-1">

                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-3 py-2 rounded-lg transition text-gray-700 hover:bg-pink-100">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Plan Your Wedding</span>
                    </span>

                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 9l6 6 6-6" />
                    </svg>

                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M18 15l-6-6-6 6" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-10 space-y-1">

                    <!-- Budgeting -->
                    <!-- <a href="{{ url('/budgeting') }}"
                        class="flex items-center gap-2 px-3 py-1 text-sm text-gray-600 hover:text-rose-700 hover:bg-pink-50 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m0 0c3.314 0 6-1.79 6-4s-2.686-4-6-4m0 0c-3.314 0-6-1.79-6-4s2.686-4 6-4" />
                        </svg>
                        Budgeting
                    </a> -->

                    <!-- Checklist -->
                    <!-- <a href="{{ url('/checklist') }}"
                        class="flex items-center gap-2 px-3 py-1 text-sm text-gray-600 hover:text-rose-700 hover:bg-pink-50 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5 8H4v-1a4 4 0 013-3.87m9-9.26a3 3 0 110 6 3 3 0 010-6zm-8 0a3 3 0 110 6 3 3 0 010-6z" />
                        </svg>
                        Checklist
                    </a> -->

                    <!-- Guest List -->
                    <!-- <a href="{{ url('/guests') }}"
                        class="flex items-center gap-2 px-3 py-1 text-sm text-gray-600 hover:text-rose-700 hover:bg-pink-50 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-1a4 4 0 00-3-3.87M9 20H4v-1a4 4 0 013-3.87m9-9.26a3 3 0 110 6 3 3 0 010-6zm-8 0a3 3 0 110 6 3 3 0 010-6z" />
                        </svg>
                        Guest List
                    </a> -->

                    <!-- My Vendors -->
                    <a href="{{ url('/myvendors') }}"
                        class="flex items-center gap-2 px-3 py-1 text-sm text-gray-600 hover:text-rose-700 hover:bg-pink-50 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Vendors Preparation
                    </a>

                </div>

            </div>

            <!-- My Profile -->
            <a href="{{ url('/profile') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-gray-700 hover:bg-pink-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M5.121 17.804A9 9 0 1118.364 4.561M12 7v5l3 3" />
                </svg>
                <span>My Profile</span>
            </a>

            <!-- Pre Wedding Preparation -->
            

            <!-- Vendor Directory -->
            <a href="{{ url('/vendors') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-gray-700 hover:bg-pink-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m-9 4h12m-13 8h14a2 2 0 002-2v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z" />
                </svg>
                <span>Browse Vendors</span>
            </a>

            <!-- Settings -->
            <!-- <a href="{{ url('/settings') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-gray-700 hover:bg-pink-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M11.983 4.5a1.5 1.5 0 012.034 0l1.193 1.193 1.34-.537a1.5 1.5 0 011.983.79l.537 1.34L21 9.983a1.5 1.5 0 010 2.034l-1.193 1.193.537 1.34a1.5 1.5 0 01-.79 1.983l-1.34.537L17.017 21a1.5 1.5 0 01-2.034 0l-1.193-1.193-1.34.537a1.5 1.5 0 01-1.983-.79l-.537-1.34L9 14.017a1.5 1.5 0 010-2.034l1.193-1.193-.537-1.34a1.5 1.5 0 01.79-1.983l1.34-.537L11.983 4.5z" />
                </svg>
                <span>Settings</span>
            </a> -->

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



    <!-- MAIN CONTENT AREA -->
    <div id="contentArea" class="flex-1 flex flex-col ml-64 transition-all duration-300">

        <!-- HEADER -->
        <header style="background: linear-gradient(135deg, #ffe5d9 0%, #ffcad4 100%);" class="shadow-md px-8 py-2 border-b border-pink-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-rose-700 mb-0">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-rose-600 mt-0">Welcome back, {{ auth()->user()->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-rose-700 font-semibold">{{ date('l, F j, Y') }}</p>
                </div>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-auto bg-pink-100">
            <div class="p-6 relative">

                <!-- BACKGROUND OVERLAY -->
                <div class="absolute inset-0 bg-center bg-cover bg-no-repeat pointer-events-none z-0 opacity-10"
                    style="background-image: url('{{ asset('image/landingoverlay.png') }}');">
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="relative z-10 mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg">
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
                    <div class="relative z-10 mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
                        <p class="text-green-700 font-semibold text-sm">✓ {{ session('success') }}</p>
                    </div>
                @endif

                <!-- Error Alert -->
                @if(session('error'))
                    <div class="relative z-10 mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg">
                        <p class="text-red-700 font-semibold text-sm">✗ {{ session('error') }}</p>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="relative z-10">
                    @yield('content')
                </div>

            </div>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

</body>
</html>
