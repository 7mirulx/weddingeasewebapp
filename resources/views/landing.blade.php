<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'WeddingEase') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col">
        <header class="w-full max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/" class="text-lg font-medium">{{ config('app.name', 'WeddingEase') }}</a>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-sm border border-transparent hover:border-black">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-sm border border-transparent hover:border-black">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-sm border border-[#e3e3e0]">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-1 flex items-center justify-center px-6">
            <section class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="py-12">
                    <h1 class="text-4xl lg:text-5xl font-semibold mb-4">Plan your perfect wedding with ease</h1>
                    <p class="text-lg text-[#706f6c] mb-6">WeddingEase helps couples and vendors coordinate every detail — guest lists, timelines, budgets and more — in one simple app.</p>

                    <div class="flex gap-3">
                        <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-[#F53003] text-white rounded-sm">Get started — it’s free</a>
                        <a href="#features" class="inline-block px-6 py-3 border border-[#e3e3e0] rounded-sm">Learn more</a>
                    </div>

                    <ul id="features" class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <li class="bg-white dark:bg-[#161615] p-4 rounded-sm shadow-[0px_1px_2px_rgba(0,0,0,0.06)]">Guest list & RSVPs</li>
                        <li class="bg-white dark:bg-[#161615] p-4 rounded-sm shadow-[0px_1px_2px_rgba(0,0,0,0.06)]">Budget tracking</li>
                        <li class="bg-white dark:bg-[#161615] p-4 rounded-sm shadow-[0px_1px_2px_rgba(0,0,0,0.06)]">Vendor management</li>
                        <li class="bg-white dark:bg-[#161615] p-4 rounded-sm shadow-[0px_1px_2px_rgba(0,0,0,0.06)]">Timeline & reminders</li>
                    </ul>
                </div>

                <div class="py-12 flex items-center justify-center">
                    <div class="w-full max-w-md bg-[#fff2f2] dark:bg-[#1D0002] rounded-lg p-6">
                        <h3 class="font-medium mb-3">Start a new plan</h3>
                        <p class="text-sm text-[#706f6c] mb-4">Create your wedding plan and invite your partner.</p>
                        <a href="{{ route('register') }}" class="block px-4 py-2 bg-[#1b1b18] text-white rounded-sm text-center">Create plan</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="w-full border-t border-[#e3e3e0] py-6">
            <div class="max-w-6xl mx-auto px-6 text-sm text-[#706f6c]">© {{ date('Y') }} {{ config('app.name', 'WeddingEase') }} — Made with ❤️</div>
        </footer>
    </body>
</html>
