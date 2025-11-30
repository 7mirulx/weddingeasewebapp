<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'WeddingEase') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-lg border-r min-h-screen">
        <div class="h-20 flex items-center px-6 border-b">
            <h1 class="text-xl font-bold text-rose-800">WeddingEase</h1>
        </div>

        <nav class="px-6 py-6 space-y-4">
            <a href="{{ url('/dashboard') }}" class="block hover:text-rose-700">Dashboard</a>
            <a href="{{ url('/profile') }}" class="block hover:text-rose-700">My Profile</a>
            <a href="{{ url('/bookings') }}" class="block hover:text-rose-700">Bookings</a>
            <a href="{{ url('/settings') }}" class="block hover:text-rose-700">Settings</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="px-6 mt-10">
            @csrf
            <button class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600">
                Logout
            </button>
        </form>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col">

        <!-- TOP RIGHT DASHBOARD LINK -->
        <div class="w-full flex justify-end px-10 py-4 text-rose-900">
            <a href="{{ url('/dashboard') }}" class="font-medium hover:text-rose-700">
                Dashboard
            </a>
        </div>

        <!-- MAIN PAGE CONTENT -->
        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>

</body>

</html>
