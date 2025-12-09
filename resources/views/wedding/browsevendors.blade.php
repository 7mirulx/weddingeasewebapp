@extends('layouts.userapp')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold mb-6 text-center text-rose-900">
        Browse Wedding Vendors
    </h1>

    {{-- =======================
         CAROUSEL
    ======================== --}}
    <div 
        x-data="{ current: 0, slides: [
            '{{ asset('image/carousel1.jpg') }}',
            '{{ asset('image/carousel2.jpg') }}',
            '{{ asset('image/carousel3.jpg') }}'
        ] }"
        x-init="setInterval(() => current = (current + 1) % slides.length, 4000)"
        class="w-full h-48 md:h-64 rounded-2xl overflow-hidden shadow-xl mb-10 relative bg-pink-200">

        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="current === index"
                x-transition.opacity
                class="absolute inset-0 bg-cover bg-center"
                :style="'background-image: url(' + slide + ')'"
            ></div>
        </template>

        <div class="absolute inset-0 bg-gradient-to-b from-white/10 to-black/20"></div>
    </div>

    {{-- =======================
         FILTER
    ======================== --}}
    <form method="GET" 
          class="bg-white/70 p-5 rounded-xl shadow-md mb-10 
                 grid grid-cols-1 md:grid-cols-4 gap-4">

        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Search vendor..."
            class="w-full px-4 py-3 border rounded-lg"/>

        <select name="category" class="px-4 py-3 border rounded-lg">
            <option value="">All Categories</option>
            @foreach($categories as $c)
                <option value="{{ $c->category }}" {{ request('category') == $c->category ? 'selected' : '' }}>
                    {{ $c->category }}
                </option>
            @endforeach
        </select>

        <select name="city" class="px-4 py-3 border rounded-lg">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city->city }}" {{ request('city') == $city->city ? 'selected' : '' }}>
                    {{ $city->city }}
                </option>
            @endforeach
        </select>

        <button class="bg-rose-600 text-white px-4 py-3 rounded-lg">
            Apply Filter
        </button>

    </form>

    <div 
  x-data="{ 
      openModal:false,
      bookedModal:false,
      successModal:false,
      isBooking:false,
      selectedVendor:{},
      bookedVendorIds: @json(auth()->user()->bookings->pluck('vendor_id')),

      async bookNow() {
          if (this.isBooking) return;   // ✅ block double click
          this.isBooking = true;

          const formData = new FormData();
          formData.append('_token', '{{ csrf_token() }}');
          formData.append('vendor_name', this.selectedVendor.vendor_name);
          formData.append('starting_price', this.selectedVendor.starting_price);
          formData.append('phone', this.selectedVendor.phone);
          formData.append('email', this.selectedVendor.email);
          formData.append('description', this.selectedVendor.description);

          try {
              const res = await fetch('/myvendors/add', {
                  method: 'POST',
                  body: formData,
                  headers: {
                      'Accept': 'application/json',
                      'X-Requested-With': 'XMLHttpRequest'
                  }
              });

              const data = await res.json();

              if (data.status === 'success') {
                  this.successModal = true;
                  this.bookedVendorIds.push(data.vendor_id);
              }

          } catch (e) {
              alert('Booking failed. Please try again.');
          }

          this.isBooking = false;
      }
  }"
  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">


        {{-- ✅✅✅ VENDOR CARDS (DESIGN ASAL KAU) --}}
        @foreach ($vendors as $vendor)
        <div class="rounded-2xl shadow-md overflow-hidden bg-white hover:shadow-xl transition border border-pink-100">

            <div 
                class="h-40 bg-pink-50 bg-cover bg-center" 
                style="background-image: url('{{ $vendor->banner_url 
                    ? asset("image/".$vendor->banner_url) 
                    : asset("image/vendor-fallback.jpg") }}');">
            </div>

            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $vendor->vendor_name }}
                </h3>

                <p class="text-sm text-gray-600">
                    {{ $vendor->category }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $vendor->city }}, {{ $vendor->state }}
                </p>

                <p class="mt-3 font-semibold text-rose-600">
                    From RM {{ number_format($vendor->starting_price, 2) }}
                </p>

                <div class="mt-1 text-sm flex items-center gap-1">
                    <span class="text-yellow-500">⭐</span>
                    <span class="text-gray-600">
                        {{ $vendor->rating_average }} ({{ $vendor->rating_count }} reviews)
                    </span>
                </div>

                <button 
                    @click.prevent="openModal = true; selectedVendor = {{ $vendor->toJson() }}"
                    class="mt-4 w-full bg-rose-600 text-white py-3 rounded-lg hover:bg-rose-700 transition">
                    View Details
                </button>
            </div>

        </div>
        @endforeach


        {{-- =======================
             VENDOR MODAL
        ======================== --}}
        <div x-show="openModal" x-cloak
             class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4">

          <div @click.away="openModal=false"
               class="bg-white w-full max-w-3xl rounded-xl shadow overflow-hidden">

            <div class="p-5 border-b flex justify-between">
              <h2 class="font-bold text-rose-700" x-text="selectedVendor.vendor_name"></h2>
              <button @click="openModal=false">✖</button>
            </div>

            <div class="p-6 grid md:grid-cols-2 gap-6">

              <div class="h-60 bg-cover rounded"
                   :style="'background-image:url(/image/' + selectedVendor.banner_url + ')'"></div>

              <div>
                <p x-text="selectedVendor.category"></p>
                <p x-text="selectedVendor.city + ', ' + selectedVendor.state"></p>
                <p class="mt-2 font-bold text-rose-600">
                    RM <span x-text="selectedVendor.starting_price"></span>
                </p>

                <p class="mt-3" x-text="selectedVendor.description"></p>

                {{-- ✅ CONTACT --}}
                <div class="mt-4 space-y-2">
                    <div x-show="selectedVendor.phone">
                        📞 
                        <a :href="'https://wa.me/6' + selectedVendor.phone" 
                           class="text-green-600 underline"
                           x-text="selectedVendor.phone"></a>
                    </div>

                    <div x-show="selectedVendor.email">
                        ✉️ 
                        <a :href="'mailto:' + selectedVendor.email"
                           class="text-blue-600 underline"
                           x-text="selectedVendor.email"></a>
                    </div>
                </div>

                {{-- ✅ BOOKING --}}
                <template x-if="bookedVendorIds.includes(selectedVendor.id)">
                    <button @click="bookedModal=true"
                            class="mt-6 w-full bg-gray-400 text-white py-3 rounded-lg">
                        Already Booked
                    </button>
                </template>

                <template x-if="!bookedVendorIds.includes(selectedVendor.id)">
                    <form class="mt-6" @submit.prevent="bookNow()">
                        <button class="w-full bg-green-600 text-white py-3 rounded-lg">
                            Book Now
                        </button>
                    </form>
                </template>

              </div>
            </div>
          </div>
        </div>

        {{-- ✅ ALREADY BOOKED --}}
        <div x-show="bookedModal" x-cloak
             class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center">
            <div class="bg-white p-6 rounded">
                <p>You already booked this vendor</p>
                <button @click="bookedModal=false"
                        class="mt-3 bg-rose-600 text-white px-4 py-2 rounded">
                    OK
                </button>
            </div>
        </div>

        {{-- ✅ SUCCESS --}}
        <div x-show="successModal" x-cloak
             class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center">
            <div class="bg-white p-6 rounded text-center">
                <p class="font-semibold text-green-600">Booking Successful!</p>
                <button @click="successModal=false; openModal=false"
                        class="mt-3 bg-green-600 text-white px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </div>

    </div>

    <div class="mt-10">
        {{ $vendors->links() }}
    </div>

</div>

@endsection
