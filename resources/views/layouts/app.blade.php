<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <style>
        .mask-gradient {
            mask-image: linear-gradient(to bottom, transparent 0%, black 40%, black 100%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 40%, black 100%);
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'WeddingEase') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-brand text-primary min-h-screen flex flex-col">

    <!-- HEADER -->
    <header>
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-xl font-semibold text-primary">WeddingEase</a>

            <nav class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md btn-secondary">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>


    <!-- MAIN CONTENT -->
    <main class="flex-1 max-w-6xl mx-auto px-6 py-12">
        @yield('content')
    </main>


    <!-- FOOTER -->
    <footer>
        <div class="max-w-6xl mx-auto px-6 py-6 text-sm text-primary/70">
            © {{ date('Y') }} {{ config('app.name', 'WeddingEase') }}
        </div>
    </footer>

</body>
</html>
