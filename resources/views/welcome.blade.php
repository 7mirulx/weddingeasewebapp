<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'WeddingEase') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-brand text-primary font-sans">

    <!-- NAVBAR -->
    <header class="w-full lg:max-w-4xl max-w-[335px] mx-auto text-sm mb-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4 pt-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-5 py-1.5 border border-primary/20 text-primary hover:border-primary rounded-sm transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-1.5 text-primary hover:border-primary border border-transparent rounded-sm transition">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-1.5 border border-primary/20 hover:border-primary text-primary rounded-sm transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="flex items-center justify-center w-full opacity-100 transition-opacity lg:grow">

        <main class="flex max-w-[335px] mx-auto w-full flex-col-reverse lg:max-w-4xl lg:flex-row">

            <!-- LEFT PANEL -->
            <div class="flex-1 p-6 pb-12 lg:p-20 bg-brand2 text-primary shadow rounded-lg">

                <h1 class="mb-2 text-2xl font-semibold">Let's get started</h1>

                <p class="mb-4 text-primary/80">
                    Laravel has an incredibly rich ecosystem.<br>
                    We suggest starting with the following.
                </p>

                <ul class="flex flex-col mb-6 space-y-4">
                    <li class="flex items-center gap-3">
                        <div class="w-3.5 h-3.5 rounded-full bg-white shadow border border-primary/20 flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                        </div>

                        <span>
                            Read the
                            <a href="https://laravel.com/docs" target="_blank"
                               class="font-medium underline underline-offset-4 text-alt ml-1">
                                Documentation
                            </a>
                        </span>
                    </li>

                    <li class="flex items-center gap-3">
                        <div class="w-3.5 h-3.5 rounded-full bg-white shadow border border-primary/20 flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                        </div>

                        <span>
                            Watch video tutorials at
                            <a href="https://laracasts.com" target="_blank"
                               class="font-medium underline underline-offset-4 text-alt ml-1">
                                Laracasts
                            </a>
                        </span>
                    </li>
                </ul>

                <ul class="flex gap-3">
                    <li>
                        <a href="https://cloud.laravel.com" target="_blank"
                           class="inline-block px-5 py-1.5 bg-primary text-white rounded-sm hover:bg-primary/90 transition">
                           Deploy now
                        </a>
                    </li>
                </ul>

            </div>

        </main>

    </div>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</body>
</html>
