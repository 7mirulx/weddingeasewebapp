@extends('layouts.userapp')

@section('page-title', 'Browse Vendors')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- PAGE HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-rose-700 mb-2 text-center">Browse Wedding Vendors</h1>
        <p class="text-gray-600 text-lg text-center">Find and book the perfect vendors for your special day</p>
    </div>

    {{-- CAROUSEL --}}
    <div 
        x-data="{ current: 0, slides: [
            '{{ asset('image/carousel1.jpg') }}',
            '{{ asset('image/carousel2.jpg') }}',
            '{{ asset('image/carousel3.webp') }}'
        ] }"
        x-init="setInterval(() => current = (current + 1) % slides.length, 4000)"
        class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-xl mb-12 relative bg-gray-300"
    >
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="current === index"
                x-transition.opacity.duration.500ms
                class="absolute inset-0 bg-cover bg-center"
                :style="'background-image: url(' + slide + ')'"
            ></div>
        </template>

        <div class="absolute inset-0 bg-gradient-to-b from-white/10 to-black/30"></div>

        {{-- Carousel Controls --}}
        <button @click="current = (current - 1 + slides.length) % slides.length" 
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button @click="current = (current + 1) % slides.length" 
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white border-2 border-pink-200 rounded-2xl p-6 shadow-sm mb-10">
        <h3 class="text-lg font-bold text-rose-700 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filter & Search
        </h3>

        <form id="filterForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Vendor Name</label>
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Search vendors..."
                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition"
                    oninput="applyFilters()"
                />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                <select id="categoryInput" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition" onchange="applyFilters()">
                    <option value="">All Categories</option>
                    @foreach(config('vendor_categories') as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                <select id="cityInput" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition" onchange="applyFilters()">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->city }}">{{ $city->city }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="button" id="resetBtn" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg transition shadow-md" onclick="resetFilters()">
                    Reset Filters
                </button>
            </div>

        </form>

        {{-- LOADING INDICATOR --}}
        <div id="filterLoading" class="hidden mt-4 flex items-center gap-2 text-rose-600">
            <div class="animate-spin">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>
            <span class="font-semibold">Filtering vendors...</span>
        </div>
    </div>

    {{-- VENDOR GRID --}}
    <div id="vendorsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

        {{-- VENDOR CARDS --}}
        @foreach ($vendors as $vendor)
        <div class="bg-white border-2 border-pink-200 rounded-2xl overflow-hidden hover:shadow-xl transition duration-300 group">
            
            {{-- IMAGE SECTION --}}
            <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                <img 
                    src="{{ $vendor->banner_url ? asset('image/'.$vendor->banner_url) : asset('image/vendor-fallback.jpg') }}" 
                    alt="{{ $vendor->vendor_name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                />
                
                {{-- RATING BADGE --}}
                <div class="absolute top-3 right-3 bg-white rounded-lg px-3 py-1 shadow-lg flex items-center gap-1">
                    <span class="text-yellow-400">⭐</span>
                    <span class="font-bold text-gray-800">{{ $vendor->rating_average ?? 'N/A' }}</span>
                </div>

                {{-- BOOKED BADGE --}}
                @if(auth()->user()->bookings->pluck('vendor_id')->contains($vendor->id))
                <div class="absolute top-3 left-3 bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-bold">
                    ✓ Booked
                </div>
                @endif
            </div>

            {{-- CONTENT SECTION --}}
            <div class="p-5">
                <h3 class="text-lg font-bold text-rose-700 mb-1">
                    {{ $vendor->vendor_name }}
                </h3>

                <p class="text-sm text-gray-600 font-semibold mb-1">
                    @php
                        $serviceIds = is_array($vendor->service_ids) ? $vendor->service_ids : json_decode($vendor->service_ids, true) ?? [];
                        $categoryNames = array_map(fn($id) => config('vendor_categories.' . $id, ''), $serviceIds);
                    @endphp
                    {{ implode(', ', array_filter($categoryNames)) }}
                </p>

                <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                    📍 {{ $vendor->city }}, {{ $vendor->state }}
                </p>

                <p class="text-xl font-bold text-rose-600 mb-2">
                    From RM {{ number_format($vendor->starting_price, 2) }}
                </p>

                <div class="text-xs text-gray-600 mb-4">
                    <span class="font-semibold">{{ $vendor->rating_count ?? 0 }}</span> reviews
                </div>

                <button 
                    type="button"
                    onclick="showVendorModal({{ $vendor->id }})"
                    class="w-full bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold py-3 rounded-lg transition shadow-md"
                >
                    View Details
                </button>
            </div>

        </div>
        @endforeach

    </div>

    {{-- MODALS WRAPPER --}}
    <div 
        x-data="modalManager()"
        x-init="loadVendors()"
    >
        {{-- VENDOR DETAILS MODAL --}}
        <template x-if="openModal && selectedVendor.id">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4" @click="openModal = false">
                <div 
                    class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border-2 border-pink-200 my-8 relative flex flex-col max-h-[90vh]"
                    @click.stop
                >
                    {{-- MODAL HEADER --}}
                    <div class="flex items-center justify-between p-6 border-b-2 border-pink-200 flex-shrink-0">
                        <h2 class="text-2xl font-bold text-rose-700" x-text="selectedVendor.vendor_name"></h2>
                        <button 
                            @click="openModal = false"
                            class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition text-2xl"
                        >
                            ✖
                        </button>
                    </div>

                    {{-- MODAL BODY - SCROLLABLE --}}
                    <div class="overflow-y-auto flex-1 p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div 
                                class="w-full h-64 rounded-xl bg-gray-300 bg-cover bg-center"
                                :style="{
                                    'backgroundImage': selectedVendor.banner_url 
                                        ? `url('/image/${selectedVendor.banner_url}')` 
                                        : `url('{{ asset('image/vendor-fallback.jpg') }}')`
                                }"
                            ></div>

                            {{-- CONTACT SECTION --}}
                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-200 rounded-xl p-4">
                                <h3 class="font-bold text-rose-700 mb-3">Contact Information</h3>
                                
                                <div class="space-y-3">
                                    {{-- PHONE --}}
                                    <template x-if="selectedVendor.phone">
                                        <a 
                                            :href="'https://wa.me/6' + selectedVendor.phone.replace(/[^0-9]/g, '')"
                                            target="_blank"
                                            class="flex items-center gap-3 p-2 bg-white rounded-lg hover:bg-green-50 transition"
                                        >
                                            <span class="text-xl">📞</span>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-600">Phone</p>
                                                <p class="font-semibold text-gray-800" x-text="selectedVendor.phone"></p>
                                            </div>
                                            <span class="text-green-600 text-sm font-bold">Chat</span>
                                        </a>
                                    </template>

                                    {{-- EMAIL --}}
                                    <template x-if="selectedVendor.email">
                                        <a 
                                            :href="'mailto:' + selectedVendor.email"
                                            class="flex items-center gap-3 p-2 bg-white rounded-lg hover:bg-blue-50 transition"
                                        >
                                            <span class="text-xl">✉️</span>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-600">Email</p>
                                                <p class="font-semibold text-gray-800 truncate" x-text="selectedVendor.email"></p>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: INFO --}}
                        <div class="flex flex-col">
                            {{-- CATEGORY & LOCATION --}}
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Category</p>
                                <p class="text-lg font-bold text-rose-700" x-text="getServiceNames(selectedVendor.service_ids)"></p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Location</p>
                                <p class="text-lg font-bold text-rose-700" x-text="selectedVendor.city + ', ' + selectedVendor.state"></p>
                            </div>

                            {{-- PRICE --}}
                            <div class="mb-6 p-4 bg-gradient-to-r from-rose-100 to-pink-100 border-2 border-rose-300 rounded-xl">
                                <p class="text-sm text-gray-600 mb-1">Starting Price</p>
                                <p class="text-3xl font-bold text-rose-700">RM <span x-text="parseFloat(selectedVendor.starting_price).toFixed(2)"></span></p>
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-2 font-bold">Description</p>
                                <p class="text-gray-700 leading-relaxed" x-text="selectedVendor.description || 'No description provided'"></p>
                            </div>

                            {{-- RATING --}}
                            <div class="flex items-center gap-2 mb-6 pb-6 border-b-2 border-pink-200">
                                <span class="text-yellow-400 text-2xl">⭐</span>
                                <div>
                                    <p class="font-bold text-gray-800" x-text="(selectedVendor.rating_average ?? 'N/A') + ' / 5'"></p>
                                    <p class="text-sm text-gray-600" x-text="(selectedVendor.rating_count ?? 0) + ' reviews'"></p>
                                </div>
                            </div>

                            {{-- REVIEWS SECTION --}}
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-3 font-bold">Customer Reviews</p>
                                <template x-if="selectedVendor.reviews && selectedVendor.reviews.length > 0">
                                    <div class="space-y-3 max-h-48 overflow-y-auto">
                                        <template x-for="review in selectedVendor.reviews" :key="review.id">
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center justify-between mb-2">
                                                    <p class="text-sm font-semibold text-gray-700">Anonymous</p>
                                                    <div class="flex gap-0.5">
                                                        <template x-for="star in 5" :key="star">
                                                            <span class="text-sm" x-text="star <= review.rating ? '⭐' : '☆'"></span>
                                                        </template>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-gray-600 leading-relaxed" x-text="review.review"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="!selectedVendor.reviews || selectedVendor.reviews.length === 0">
                                    <p class="text-xs text-gray-500">No reviews yet</p>
                                </template>
                            </div>

                            {{-- BOOKING BUTTON --}}
                            <template x-if="isVendorBooked(selectedVendor.id)">
                                <button 
                                    class="w-full bg-gray-400 text-white font-semibold py-3 rounded-lg cursor-not-allowed"
                                    disabled
                                >
                                    ✓ Already Booked
                                </button>
                            </template>

                            <template x-if="!isVendorBooked(selectedVendor.id)">
                                <button 
                                    @click="bookNow()"
                                    :disabled="isBooking"
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 rounded-lg transition disabled:opacity-50"
                                >
                                    <span x-show="!isBooking">🎉 Book Now</span>
                                    <span x-show="isBooking">Processing...</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- SUCCESS MODAL --}}
        <template x-if="successModal">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
                <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border-2 border-green-200 p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-green-700 mb-2">Booking Successful! 🎉</h3>
                    <p class="text-gray-600 mb-6">The vendor has been added to your bookings. You can manage it in your My Vendors page.</p>
                    <button 
                        @click="successModal = false; openModal = false"
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 rounded-lg transition"
                    >
                        Done
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-center">
        {{ $vendors->links() }}
    </div>

</div>

<script>
// Global vendors data
let vendorsData = @json($vendors->items());
let bookedVendorIds = @json(auth()->user()->bookings->pluck('vendor_id'));
let filterTimeout;

// Show modal function
function showVendorModal(vendorId) {
    const vendor = vendorsData.find(v => v.id === vendorId);
    if (vendor) {
        window.modalState.selectedVendor = vendor;
        window.modalState.openModal = true;
    }
}

// Apply filters with AJAX
async function applyFilters() {
    clearTimeout(filterTimeout);
    const loading = document.getElementById('filterLoading');
    loading.classList.remove('hidden');

    const search = document.getElementById('searchInput').value;
    const category = document.getElementById('categoryInput').value;
    const city = document.getElementById('cityInput').value;

    filterTimeout = setTimeout(async () => {
        try {
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            if (city) params.append('city', city);

            const response = await fetch(`/vendors/filter?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                vendorsData = data.vendors;
                bookedVendorIds = data.bookedVendorIds;
                renderVendors();
            }
        } catch (error) {
            console.error('Filter error:', error);
            alert('Error applying filters. Please try again.');
        } finally {
            loading.classList.add('hidden');
        }
    }, 500); // Debounce 500ms
}

// Reset filters
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryInput').value = '';
    document.getElementById('cityInput').value = '';
    applyFilters();
}

// Render vendor cards
function renderVendors() {
    const grid = document.getElementById('vendorsGrid');
    const fallbackPath = '{{ asset('image/vendor-fallback.jpg') }}';
    
    if (vendorsData.length === 0) {
        grid.innerHTML = `
            <div class="col-span-full text-center py-16 px-8 bg-white border-2 border-dashed border-pink-300 rounded-2xl">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No Vendors Found</h3>
                <p class="text-gray-600">Try adjusting your filters to find vendors</p>
            </div>
        `;
        return;
    }

    grid.innerHTML = vendorsData.map(vendor => {
        const imageUrl = vendor.banner_url ? '/image/' + vendor.banner_url : fallbackPath;

        return `
        <div class="bg-white border-2 border-pink-200 rounded-2xl overflow-hidden hover:shadow-xl transition duration-300 group">
            <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                <img 
                    src="${imageUrl}" 
                    alt="${vendor.vendor_name}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                    onerror="this.src='${fallbackPath}'"
                />
                
                <div class="absolute top-3 right-3 bg-white rounded-lg px-3 py-1 shadow-lg flex items-center gap-1">
                    <span class="text-yellow-400">⭐</span>
                    <span class="font-bold text-gray-800">${vendor.rating_average ?? 'N/A'}</span>
                </div>

                ${bookedVendorIds.includes(vendor.id) ? `
                <div class="absolute top-3 left-3 bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-bold">
                    ✓ Booked
                </div>
                ` : ''}
            </div>

            <div class="p-5">
                <h3 class="text-lg font-bold text-rose-700 mb-1">
                    ${vendor.vendor_name}
                </h3>

                <p class="text-sm text-gray-600 font-semibold mb-1">
                    ${vendor.service_ids}
                </p>

                <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                    📍 ${vendor.city}, ${vendor.state}
                </p>

                <p class="text-xl font-bold text-rose-600 mb-2">
                    From RM ${parseFloat(vendor.starting_price).toFixed(2)}
                </p>

                <div class="text-xs text-gray-600 mb-4">
                    <span class="font-semibold">${vendor.rating_count ?? 0}</span> reviews
                </div>

                <button 
                    type="button"
                    onclick="showVendorModal(${vendor.id})"
                    class="w-full bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold py-3 rounded-lg transition shadow-md"
                >
                    View Details
                </button>
            </div>
        </div>
        `;
    }).join('');
}

// Alpine.js Modal Manager
function modalManager() {
    const vendorCategories = @json(config('vendor_categories'));
    
    return {
        openModal: false,
        bookedModal: false,
        successModal: false,
        isBooking: false,
        selectedVendor: {},
        bookedVendorIds: bookedVendorIds,

        loadVendors() {
            window.modalState = this;
        },

        getServiceNames(serviceIds) {
            if (!serviceIds) return '-';
            if (typeof serviceIds === 'string') {
                try {
                    serviceIds = JSON.parse(serviceIds);
                } catch (e) {
                    return '-';
                }
            }
            if (!Array.isArray(serviceIds)) return '-';
            
            const names = serviceIds
                .map(id => vendorCategories[id] || '')
                .filter(name => name !== '');
            
            return names.length > 0 ? names.join(', ') : '-';
        },

        isVendorBooked(vendorId) {
            return this.bookedVendorIds.includes(vendorId);
        },

        async bookNow() {
            if (this.isBooking) return;
            this.isBooking = true;

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('vendor_id', this.selectedVendor.id);

            try {
                const res = await fetch('/bookings/create', {
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
                    setTimeout(() => {
                        this.openModal = false;
                        this.successModal = false;
                    }, 1500);
                } else {
                    alert('Booking failed. Please try again.');
                }

            } catch (e) {
                console.error(e);
                alert('Booking failed. Please try again.');
            }

            this.isBooking = false;
        }
    }
}
</script>

@endsection
