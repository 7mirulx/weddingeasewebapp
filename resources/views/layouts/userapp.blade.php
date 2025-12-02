<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'WeddingEase') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-100 min-h-screen flex">

    <!-- SIDEBAR (AUTO SHRINK) -->
    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-white shadow-lg border-r min-h-screen fixed left-0 top-0 flex flex-col justify-between transition-all duration-300">



        <!-- TOP SECTION -->
        <div class="pt-6 px-6 pb-4">
            <h1 class="text-xl font-bold text-rose-800 sidebar-text">WeddingEase</h1>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 px-4 space-y-1">

            <a href="{{ url('/dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4m10-11v11a1 1 0 01-1 1h-4m-6 0h6" />
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="{{ url('/profile') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M5.121 17.804A9 9 0 1118.364 4.561M12 7v5l3 3" />
                </svg>
                <span class="sidebar-text">My Profile</span>
            </a>

            <a href="{{ url('/budgeting') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                
                <!-- Dollar Sign Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                    stroke="currentColor" class="h-5 w-5 text-rose-700">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M12 6v12m0 0c3.314 0 6-1.79 6-4s-2.686-4-6-4m0 0c-3.314 0-6-1.79-6-4s2.686-4 6-4" />
                </svg>

                <span class="sidebar-text">Budgeting</span>
            </a>


            <a href="{{ url('/preweddingpreparation') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-rose-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m2-3.5V18a2 2 0 01-2 2H9a2 2 0 01-2-2V6.5A2.5 2.5 0 019.5 4h5A2.5 2.5 0 0117 6.5z" />
                </svg>
                <span class="sidebar-text">Pre Wedding Preparation</span>
            </a>

            <a href="{{ url('/vendors') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m-9 4h12m-13 8h14a2 2 0 002-2v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z" />
                </svg>
                <span class="sidebar-text">Vendors</span>
            </a>

            <a href="{{ url('/bookings') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                <span class="sidebar-text">Bookings</span>
            </a>

            <a href="{{ url('/settings') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 hover:text-rose-700 sidebar-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-700"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M11.983 4.5a1.5 1.5 0 012.034 0l1.193 1.193 1.34-.537a1.5 1.5 0 011.983.79l.537 1.34L21 9.983a1.5 1.5 0 010 2.034l-1.193 1.193.537 1.34a1.5 1.5 0 01-.79 1.983l-1.34.537L17.017 21a1.5 1.5 0 01-2.034 0l-1.193-1.193-1.34.537a1.5 1.5 0 01-1.983-.79l-.537-1.34L9 14.017a1.5 1.5 0 010-2.034l1.193-1.193-.537-1.34a1.5 1.5 0 01.79-1.983l1.34-.537L11.983 4.5z" />
                </svg>
                <span class="sidebar-text">Settings</span>
            </a>

        </nav>

        <!-- LOGOUT FIXED BOTTOM -->
        <!-- LOGOUT FIXED BOTTOM -->
        <form method="POST" action="{{ route('logout') }}" class="px-4 py-4">
            @csrf
            <button
                class="flex items-center gap-3 px-3 py-2 w-full rounded-lg hover:bg-red-50 text-red-600 hover:text-red-700 transition sidebar-text">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
                Logout
            </button>
        </form>


    </aside>

    


    <!-- MAIN CONTENT AREA -->
    <div id="contentArea" class="flex-1 flex flex-col ml-64 transition-all duration-300">

        <main class="flex-1 p-10 relative overflow-hidden">

            <!-- BACKGROUND OVERLAY IMAGE -->
            <div class="absolute inset-0 bg-center bg-cover bg-no-repeat pointer-events-none z-0"
                style="background-image: url('{{ asset('image/landingoverlay.png') }}'); opacity:0.15;">
            </div>

            <!-- PAGE CONTENT -->
            <div class="relative z-10">
                @yield('content')
            </div>

        </main>

    </div>

  <!--  ALPINE SCRIPT -->
    <script src="https://unpkg.com/alpinejs" defer></script>


    <!-- AUTO SHRINK SCRIPT -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('contentArea');
        const textElements = document.querySelectorAll('.sidebar-text');
        

        let timer;

        function shrink() {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-5', 'overflow-hidden', 'border-r', 'border-gray-300');

            content.classList.remove('ml-64');
            content.classList.add('ml-5');

            textElements.forEach(el => el.classList.add('opacity-0'));
        }


        function expand() {
            sidebar.classList.remove('w-5', 'overflow-hidden', 'border-r', 'border-gray-300');
            sidebar.classList.add('w-64');

            content.classList.remove('ml-5');
            content.classList.add('ml-64');

            textElements.forEach(el => el.classList.remove('opacity-0'));
        }


        function startTimer() {
            clearTimeout(timer);
            timer = setTimeout(shrink, 3500); // auto collapse after idle
        }

        sidebar.addEventListener('mouseenter', () => {
            expand();
            clearTimeout(timer);
        });

        sidebar.addEventListener('mouseleave', startTimer);

        // auto start collapse
        startTimer();
    </script>


</body>
</html>
