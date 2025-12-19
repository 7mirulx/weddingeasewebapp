@extends('layouts.publicapp')

@section('content')

<div class="relative overflow-hidden">
    <!-- Auto-Scroll Carousel -->
     <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
        <div class="py-1">
            <h1 class="text-4xl lg:text-5xl font-semibold mb-4">Plan your perfect wedding with us</h1>
            <p class="text-lg dark:text-gray-900 mb-6">WeddingEase helps couples and vendors coordinate every detail — guest lists, timelines, budgets and more — in one simple app.</p>

            <div class="flex gap-3">
                <a href="{{ route('register') }}" class="inline-block px-6 py-3 btn-primary rounded-md">Get started — it’s free</a>
                <a href="#features" class="inline-block px-6 py-3 border border-gray-200 rounded-md btn-alt">Learn more</a>
            </div>

            <!-- <ul id="features" class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <li class="bg-white p-4 rounded-md shadow">Guest list & RSVPs</li>
                <li class="bg-white p-4 rounded-md shadow">Budget tracking</li>
                <li class="bg-white p-4 rounded-md shadow">Vendor management</li>
                <li class="bg-white p-4 rounded-md shadow">Timeline & reminders</li>
            </ul> -->
        </div>

        <div class="py-12 flex items-center justify-center">
            <div class="w-full max-w-md bg-brand2 rounded-lg p-6">
                <h3 class="font-medium mb-3">Start a new plan</h3>
                <p class="text-sm dark:text-gray-900 mb-4">Create your wedding plan and invite your partner.</p>
                <a href="{{ route('register') }}" class="block px-4 py-2 btn-primary rounded-md text-center">Create plan</a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-brand relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 relative">
            <h2 class="text-xl font-bold mb-12 text-gray-900">
                Our Featured Vendors
            </h2>

            <!-- Fade mask edges (Dribbble style) -->
            <div class="pointer-events-none absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-brand to-transparent z-10"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-brand to-transparent z-10"></div>

            <div class="overflow-hidden">
                <div class="flex animate-scroll gap-6 md:gap-10 items-center" id="carouselTrack">

                    @php
                        $vendors = [
                            ['img'=>'BigOnionFoodCaterer.jpg','name'=>'BigOnion Food Caterer','title'=>'Ultimate Guide','subtitle'=>'to Wedding Catering'],
                            ['img'=>'ThePhotoz.jpg','name'=>'ThePhotoz','title'=>'Choosing','subtitle'=>'Your Photographer'],
                            ['img'=>'RamaRamaWeddingDeco.jpeg','name'=>'Rama Rama Wedding Deco','title'=>'Decor Ideas','subtitle'=>'That Impress'],
                            ['img'=>'MakeupbyNadira.jpg','name'=>'Makeup by Nadira','title'=>'Bridal Makeup','subtitle'=>'Trends 2025'],
                            ['img'=>'TheKLLiveBand.jpg','name'=>'The KL Live Band','title'=>'Live Bands','subtitle'=>'Guests Love'],
                            ['img'=>'RizmanRuzainiBridal.jpg','name'=>'Rizman Ruzaini Bridal','title'=>'Designer Gowns','subtitle'=>'That Shine'],
                            ['img'=>'DewanKomunitiCheras.jpg','name'=>'Dewan Komuniti Cheras','title'=>'Venue Picks','subtitle'=>'Around KL'],
                            ['img'=>'TheCallaWeddingDecor.jpg','name'=>'The Calla Wedding Decor','title'=>'Floral Styling','subtitle'=>'That Wows'],
                        ];
                    @endphp

                    @foreach($vendors as $vendor)
                    <div class="carousel-item flex-shrink-0 w-[300px] sm:w-[420px] lg:w-[520px] px-2 md:px-4">
                        <div class="relative h-[380px] rounded-2xl overflow-hidden shadow-xl">
                            <img src="{{ asset('image/'.$vendor['img']) }}" alt="{{ $vendor['name'] }}" class="absolute inset-0 w-full h-full object-cover">

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>

                            <!-- Content -->
                            <div class="absolute bottom-6 left-6 right-6 text-white">
                                <span class="inline-block mb-2 px-3 py-1 text-xs font-semibold bg-red-500 rounded">FEATURED</span>

                                <h3 class="text-2xl font-bold leading-tight">
                                    {{ $vendor['title'] }}<br>
                                    <span class="font-extrabold">{{ $vendor['subtitle'] }}</span>
                                </h3>

                                <div class="mt-4 flex items-center gap-2 text-sm opacity-90">
                                    <span>Read more</span>
                                    <span class="w-6 h-6 border border-white rounded-full flex items-center justify-center">→</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <style>
        /* Mobile: 1 item at a time */
        @keyframes slideStepMobile {
            0% {
                transform: translateX(0);
            }
            12% {
                transform: translateX(-100%);
            }
            14% {
                transform: translateX(-100%);
            }
            26% {
                transform: translateX(-200%);
            }
            28% {
                transform: translateX(-200%);
            }
            40% {
                transform: translateX(-300%);
            }
            42% {
                transform: translateX(-300%);
            }
            54% {
                transform: translateX(-400%);
            }
            56% {
                transform: translateX(-400%);
            }
            68% {
                transform: translateX(-500%);
            }
            70% {
                transform: translateX(-500%);
            }
            82% {
                transform: translateX(-600%);
            }
            84% {
                transform: translateX(-600%);
            }
            96% {
                transform: translateX(-700%);
            }
            98% {
                transform: translateX(-700%);
            }
            100% {
                transform: translateX(0);
            }
        }

        /* Tablet: 2 items at a time */
        @keyframes slideStepTablet {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-50%);
            }
            25% {
                transform: translateX(-50%);
            }
            45% {
                transform: translateX(-100%);
            }
            50% {
                transform: translateX(-100%);
            }
            70% {
                transform: translateX(-150%);
            }
            75% {
                transform: translateX(-150%);
            }
            95% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(0);
            }
        }

        /* Desktop: 3 items at a time */
        @keyframes slideStepDesktop {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(calc(-100% / 3));
            }
            25% {
                transform: translateX(calc(-100% / 3));
            }
            45% {
                transform: translateX(calc(-200% / 3));
            }
            50% {
                transform: translateX(calc(-200% / 3));
            }
            70% {
                transform: translateX(calc(-300% / 3));
            }
            75% {
                transform: translateX(calc(-300% / 3));
            }
            95% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(0);
            }
        }

        #carouselTrack {
            display: flex;
            animation: slideStepMobile 28s ease-in-out infinite;
            will-change: transform;
            align-items: center;
        }

        /* DRIBBBLE DEPTH FEEL */
        .carousel-item {
            opacity: 0.45;
            transform: scale(0.92);
            transition: all 0.6s ease;
        }

        #carouselTrack:hover .carousel-item {
            opacity: 0.6;
        }

        #carouselTrack .carousel-item:hover {
            opacity: 1;
            transform: scale(1);
            z-index: 5;
        }

        @media (min-width: 640px) {
            #carouselTrack {
                animation: slideStepTablet 24s ease-in-out infinite;
            }
        }

        @media (min-width: 1024px) {
            #carouselTrack {
                animation: slideStepDesktop 20s ease-in-out infinite;
            }
        }

        #carouselTrack:hover {
            animation-play-state: paused;
        }

        #carouselTrack > div {
            flex-shrink: 0;
        }
    </style>

    <script>
        // Duplicate carousel items for seamless infinite loop
        const track = document.getElementById('carouselTrack');
        if (track) {
            const items = Array.from(track.querySelectorAll('div[class*="flex-shrink"]'));
            // Clone all items and append to create seamless loop
            items.forEach(item => {
                const clone = item.cloneNode(true);
                track.appendChild(clone);
            });
        }
    </script>

</div>
<!-- <div class="absolute bottom-0 left-0 w-full h-[350px] bg-cover bg-bottom opacity-25 pointer-events-none" style="background-image: url('{{ asset('image/landingoverlay.png') }}')"></div> -->
@endsection
