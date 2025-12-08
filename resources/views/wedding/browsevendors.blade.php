@extends('layouts.userapp')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- PAGE TITLE --}}
    <h1 class="text-3xl font-bold mb-6 text-center text-rose-900">
        Browse Wedding Vendors
    </h1>

    {{-- =======================
         CAROUSEL SECTION
    ======================== --}}
    <div 
        x-data="{ current: 0, slides: [
            '{{ asset('image/carousel1.jpg') }}',
            '{{ asset('image/carousel2.jpg') }}',
            '{{ asset('image/carousel3.jpg') }}'
        ] }"
        x-init="setInterval(() => current = (current + 1) % slides.length, 4000)"
        class="w-full h-48 md:h-64 rounded-2xl overflow-hidden shadow-xl mb-10 relative bg-pink-200">

        {{-- Slides --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="current === index"
                x-transition.opacity
                class="absolute inset-0 bg-cover bg-center"
                :style="'background-image: url(' + slide + ')'"
            ></div>
        </template>

        {{-- Fade Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-white/10 to-black/20"></div>

        {{-- Dots --}}
        <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-2 z-20">
            <template x-for="(slide, index) in slides" :key="index">
                <button 
                    @click="current = index"
                    :class="current === index ? 'bg-white' : 'bg-white/50'"
                    class="w-3 h-3 rounded-full transition shadow"
                ></button>
            </template>
        </div>

    </div>



    {{-- =======================
         FILTER SECTION
    ======================== --}}
    <form method="GET" 
          class="bg-white/70 backdrop-blur-md p-5 rounded-xl shadow-md mb-10 
                 grid grid-cols-1 md:grid-cols-4 gap-4 border border-pink-100">

        {{-- Search Bar --}}
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Search vendor name..."
            class="w-full px-4 py-3 border border-pink-200 rounded-lg bg-white shadow-sm
                   focus:ring-pink-300 focus:border-pink-400"
        />

        {{-- Category Filter --}}
        <select name="category" 
            class="px-4 py-3 border border-pink-200 rounded-lg bg-white shadow-sm
                   focus:ring-pink-300 focus:border-pink-400">
            <option value="">All Categories</option>
            @foreach($categories as $c)
                <option value="{{ $c->category }}" {{ request('category') == $c->category ? 'selected' : '' }}>
                    {{ $c->category }}
                </option>
            @endforeach
        </select>

        {{-- City Filter --}}
        <select name="city" 
            class="px-4 py-3 border border-pink-200 rounded-lg bg-white shadow-sm
                   focus:ring-pink-300 focus:border-pink-400">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city->city }}" {{ request('city') == $city->city ? 'selected' : '' }}>
                    {{ $city->city }}
                </option>
            @endforeach
        </select>

        {{-- Filter Button --}}
        <button 
            class="bg-rose-600 text-white px-4 py-3 rounded-lg hover:bg-rose-700 shadow-sm transition">
            Apply Filter
        </button>

    </form>



    {{-- =======================
         VENDOR GRID SECTION
    ======================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach ($vendors as $vendor)
        <a href="{{ route('vendors.show', $vendor->id) }}" 
           class="rounded-2xl shadow-md overflow-hidden bg-white hover:shadow-xl 
                  transition border border-pink-100">

            {{-- Banner --}}
            <div 
                class="h-40 bg-pink-50 bg-cover bg-center" 
                style="background-image: url('{{ $vendor->banner_url 
                    ? asset("image/".$vendor->banner_url) 
                    : asset("image/vendor-fallback.jpg") }}');">
            </div>


            {{-- Card Body --}}
            <div class="p-5">

                {{-- Vendor Name --}}
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $vendor->vendor_name }}
                </h3>

                {{-- Category --}}
                <p class="text-sm text-gray-600">
                    {{ $vendor->category }}
                </p>

                {{-- Location --}}
                <p class="mt-1 text-sm text-gray-500">
                    {{ $vendor->city }}, {{ $vendor->state }}
                </p>

                {{-- Price --}}
                <p class="mt-3 font-semibold text-rose-600">
                    From RM {{ number_format($vendor->starting_price, 2) }}
                </p>

                {{-- Rating --}}
                <div class="mt-1 text-sm flex items-center gap-1">
                    <span class="text-yellow-500">⭐</span>
                    <span class="text-gray-600">{{ $vendor->rating_average }} ({{ $vendor->rating_count }} reviews)</span>
                </div>

                {{-- Button --}}
                <button 
                    class="mt-4 w-full bg-rose-600 text-white py-2 rounded-lg hover:bg-rose-700 transition">
                    View Details
                </button>

            </div>

        </a>
        @endforeach

    </div>



    {{-- Pagination --}}
    <div class="mt-10">
        {{ $vendors->links() }}
    </div>

</div>

@endsection
