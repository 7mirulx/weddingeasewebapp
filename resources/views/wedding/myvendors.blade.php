@extends('layouts.userapp')

@section('content')

@php
    // PROGRESS CALCULATION
    $services = config('vendor_categories');
    $totalCategories = count($services);

    $bookedServices = collect($vendors)
        ->flatMap(fn($b) => optional($b->vendor)->service_ids ?? [])
        ->unique()
        ->values();

    $bookedCount = $bookedServices->count();
    $progress = $totalCategories > 0 ? round(($bookedCount / $totalCategories) * 100) : 0;

    // MISSING SERVICES
    // All categories
     $allServices = config('vendor_categories');       // Full service list
    $bookedServiceIds = $bookedServices->toArray();   // Dari progress calculation
    $missingServices = collect($allServices)
        ->reject(fn($label, $id) => in_array($id, $bookedServiceIds));

    $completedServices = collect($allServices)
        ->filter(fn($label, $id) => in_array($id, $bookedServiceIds));
@endphp






<div class="max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold text-rose-900">My Vendors</h1>
    <p class="text-gray-600 mt-1">Vendors you're hiring for your wedding ✨</p>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transition.opacity.duration.500ms
        class="fixed inset-0 flex items-center justify-center z-[9999]"
        >
        <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>

        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-xl z-[99999] p-6 border border-green-300">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">Success</h3>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                    ✖
                </button>
            </div>
            <p class="text-sm text-gray-700">
                {{ session('success') }}
            </p>
        </div>
    </div>
    @endif


    {{-- ===================== MISSING + CHECKLIST UI ===================== --}}
    <div class="bg-gradient-to-br from-white via-rose-50 to-pink-100 p-7  shadow-xl border border-rose-200 mt-10 backdrop-blur">


        {{-- ⚠️ WARNING BANNER --}}
        @if($missingServices->count())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 flex items-center justify-between">
            <div>
                <p class="font-semibold">
                    ⚠️ You’re missing {{ $missingServices->count() }} essential services
                </p>
                <p class="text-sm mt-1">
                    {{ $missingServices->implode(' • ') }}
                </p>
            </div>

            <button 
                onclick="document.getElementById('addVendorModal').classList.remove('hidden')" 
                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition">
                Add Now
            </button>
        </div>
        @endif


        {{-- ✅ CHECKLIST CARD --}}
        <h3 class="text-lg font-semibold text-rose-700 mb-4">
            ✅ Wedding Services Checklist
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">

            {{-- COMPLETED --}}
            @foreach($completedServices as $label)
                <div class="flex items-center gap-2 text-green-700 font-medium">
                    ✅ {{ $label }}
                </div>
            @endforeach

            {{-- MISSING --}}
            @foreach($missingServices as $label)
                <div class="flex items-center gap-2 text-gray-500">
                    ⬜ {{ $label }}
                </div>
            @endforeach

        </div>

        {{-- 📊 PROGRESS BAR --}}
        <div class="mt-6">
            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                <div class="bg-rose-500 h-2 rounded-full transition-all" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Progress: {{ $progress }}%
            </p>
        </div>
    </div>
    {{-- ===================== END MISSING UI ===================== --}}



    {{-- VENDOR LIST --}}
    <div class="flex flex-col gap-6 mt-8">

        @foreach($vendors as $booking)
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition relative border border-gray-100">

            <h2 class="text-xl font-semibold text-rose-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-600" fill="none" 
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                {{ $booking->vendor->vendor_name }}
            </h2>

            {{-- CATEGORIES --}}
            @if ($booking->vendor->service_ids)
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach ($booking->vendor->service_ids as $sid)
                    <span class="px-2 py-1 bg-green-300 text-black-500 rounded-full text-xs">
                        {{ $services[$sid] ?? 'Unknown' }}
                    </span>
                @endforeach
            </div>
            @endif

            {{-- PRICE --}}
            <p class="mt-3 text-rose-700 font-bold text-lg">
                RM {{ number_format($booking->vendor->starting_price, 2) }}
            </p>

            {{-- PAYMENT --}}
            @php
                $deposit = $booking->payment_progress['deposit'] ?? 0;
                $price = $booking->vendor->starting_price ?? 0;
                $percent = $price > 0 ? round(($deposit / $price) * 100) : 0;
            @endphp

            <p class="mt-1 text-sm text-gray-700">
                Status: 
                @if($deposit > 0)
                    Deposit Paid – 
                    <span class="text-rose-600 font-semibold">{{ $percent }}%</span>
                @else
                    Not Paid
                @endif
            </p>

            {{-- Current Rating --}}
            @if($booking->vendor->rating)
                <p class="mt-1 text-yellow-500 text-sm">Rating: ⭐ {{ $booking->vendor->rating }}/5</p>
            @endif

            {{-- ACTION BUTTONS --}}
            <div class="mt-4 flex justify-end gap-5 items-center">

                {{-- ⭐ RATE BUTTON --}}
                @if($booking->is_completed)
                <button 
                    onclick="document.getElementById('rateModal-{{ $booking->id }}').classList.remove('hidden')"
                    class="flex items-center gap-1 text-yellow-600 hover:text-yellow-700 font-medium"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.443a1 1 0 00-.364 1.118l1.286 3.947c.3.92-.755 1.688-1.54 1.118l-3.36-2.443a1 1 0 00-1.175 0L5.03 18.0c-.784.57-1.838-.197-1.539-1.118l1.287-3.947a1 1 0 00-.364-1.118L1.05 9.37c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.31-3.943z"/>
                    </svg>
                    Rate
                </button>
                @endif

                {{-- DELETE --}}
                <form method="POST" action="{{ route('vendors.delete', $booking->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>

                {{-- EDIT --}}
                <button 
                    onclick="document.getElementById('editVendorModal-{{ $booking->id }}').classList.remove('hidden')"
                    class="text-rose-600 hover:text-rose-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M11 5h-4a2 2 0 00-2 2v4m0 4v4a2 2 0 002 2h4m4 0h4a2 2 0 002-2v-4m0-4V7a2 2 0 00-2-2h-4m-4 0a2 2 0 012-2h4m-6 6l6-6m0 0l6 6m-6-6v12"/>
                    </svg>
                </button>

            </div>

        </div>
        @endforeach

    </div>

</div>


{{-- ===================== RATE MODALS ===================== --}}
@foreach($vendors as $booking)
<div 
    id="rateModal-{{ $booking->id }}"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4"
>
    <div class="bg-white w-full max-w-lg p-6 rounded-2xl shadow-xl">

        <h2 class="text-2xl font-semibold text-rose-900 mb-4">
            Rate {{ $booking->vendor->vendor_name }}
        </h2>

        <form action="{{ route('vendors.rate', $booking->id) }}" method="POST">
            @csrf

            <label class="block mb-2 text-gray-700">Rating</label>
            <select name="rating" required class="w-full border rounded-lg p-2 mb-4">
                <option value="">Choose Rating</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>

            <label class="block mb-2 text-gray-700">Review (optional)</label>
            <textarea name="review" class="w-full border rounded-lg p-2 mb-4"></textarea>

            <div class="flex justify-end gap-3 mt-6">
                <button 
                    type="button"
                    onclick="document.getElementById('rateModal-{{ $booking->id }}').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 rounded-lg"
                >Cancel</button>

                <button class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                    Submit Rating
                </button>
            </div>

        </form>

    </div>
</div>
@endforeach



{{-- ===================== EDIT BOOKING MODAL ===================== --}}
@foreach($vendors as $booking)
<div 
    id="editVendorModal-{{ $booking->id }}" 
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4"
>
    <div class="bg-white w-full max-w-lg p-6 rounded-2xl shadow-xl">

        <h2 class="text-2xl font-semibold text-rose-900 mb-4">Edit Booking</h2>

        <form action="{{ route('vendors.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Vendor Name</label>
                <input type="text" value="{{ $booking->vendor->vendor_name }}" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deposit Paid (RM)</label>
                <input 
                    type="number" 
                    name="deposit"
                    class="w-full border rounded-lg p-2"
                    value="{{ $booking->payment_progress['deposit'] ?? 0 }}"
                >
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Booking Status</label>
                <select name="is_completed" class="w-full border rounded-lg p-2">
                    <option value="0" {{ $booking->is_completed ? '' : 'selected' }}>In Progress</option>
                    <option value="1" {{ $booking->is_completed ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button 
                    type="button"
                    onclick="document.getElementById('editVendorModal-{{ $booking->id }}').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 rounded-lg"
                >Cancel</button>

                <button class="px-5 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>
@endforeach



{{-- ===================== ADD VENDOR MODAL ===================== --}}
<div 
    id="addVendorModal" 
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4"
    x-data="vendorForm()"
>
    <div class="bg-white w-full max-w-lg p-6 rounded-2xl shadow-xl">

        <h2 class="text-2xl font-semibold text-rose-900 mb-4">Add Vendor</h2>

        <form action="/myvendors/add" method="POST" autocomplete="off">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- SEARCH --}}
                <div class="md:col-span-2 relative">
                    <label class="block text-gray-700">Vendor Name</label>
                    <input
                        type="text"
                        name="vendor_name"
                        x-model="vendor_name"
                        @input="selectedVendor = null; searchVendors()"
                        class="w-full border rounded-lg p-2"
                        placeholder="Search or type new vendor..."
                        autocomplete="off"
                    >

                    <div
                        x-show="suggestions.length"
                        @click.outside="suggestions = []"
                        class="absolute left-0 right-0 bg-white border rounded-lg mt-1 shadow-lg z-[9999] max-h-60 overflow-y-auto"
                    >
                        <template x-for="v in suggestions" :key="v.id">
                            <div
                                class="px-3 py-2 hover:bg-rose-50 cursor-pointer"
                                @click="fillVendor(v)"
                            >
                                <div class="font-medium text-gray-800" x-text="v.vendor_name"></div>
                                <div class="text-gray-400 text-sm" x-text="'RM ' + (v.starting_price ?? 0)"></div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- CATEGORIES --}}
                <div class="relative md:col-span-2">
                    <label class="block text-gray-700">Categories (Choose multiple)</label>

                    <div 
                        @click="catOpen = !catOpen"
                        class="w-full border rounded-lg p-3 bg-white cursor-pointer flex flex-col gap-2 min-h-[60px]"
                    >
                        <template x-for="(label, id) in selectedServices" :key="id">
                            <div class="flex justify-between items-center px-3 py-2 bg-rose-100 text-rose-700 text-sm font-semibold rounded-md shadow-sm">
                                <span x-text="label"></span>
                                <button 
                                    type="button"
                                    @click.stop="delete selectedServices[id]"
                                    class="text-rose-600 hover:text-rose-900 text-xl leading-none">
                                    &times;
                                </button>
                            </div>
                        </template>

                        <span 
                            x-show="Object.keys(selectedServices).length === 0" 
                            class="text-gray-400">
                            Select one or more categories...
                        </span>
                    </div>

                    <div
                        x-show="catOpen"
                        @click.outside="catOpen = false"
                        class="absolute bg-white border rounded-lg mt-2 w-full shadow-xl max-h-60 overflow-y-auto z-[9999] p-2"
                    >
                        @foreach ($services as $id => $label)
                        <div 
                            class="flex items-center gap-2 px-2 py-1 hover:bg-rose-50 rounded cursor-pointer"
                            @click="
                                if (selectedServices[{{ $id }}]) {
                                    delete selectedServices[{{ $id }}];
                                } else {
                                    selectedServices[{{ $id }}] = '{{ $label }}';
                                }
                            "
                        >
                            <input type="checkbox" class="w-4 h-4 text-rose-600" :checked="selectedServices[{{ $id }}]">
                            <span>{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>

                    <template x-for="(label, id) in selectedServices" :key="'hidden-'+id">
                        <input type="hidden" name="service_ids[]" :value="id">
                    </template>
                </div>

                {{-- AUTO-FILLS --}}
                <div>
                    <label class="block text-gray-700">Starting Price (RM)</label>
                    <input type="number" name="starting_price" x-model="starting_price" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-gray-700">Phone</label>
                    <input type="text" name="phone" x-model="phone" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" x-model="email" class="w-full border rounded-lg p-2">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700">Description</label>
                    <textarea name="description" x-model="description" class="w-full border rounded-lg p-2"></textarea>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button 
                    type="button"
                    onclick="document.getElementById('addVendorModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 rounded-lg"
                >Cancel</button>

                <button class="px-5 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700">
                    Save
                </button>
            </div>

        </form>

    </div>
</div>


<script>
function vendorForm() {
    return {
        vendor_name: '',
        suggestions: [],
        selectedVendor: null,
        selectedServices: {},
        catOpen: false,
        serviceLabels: @js($services),

        starting_price: '',
        phone: '',
        email: '',
        description: '',

        searchVendors() {
            if (this.vendor_name.length > 1) {
                fetch('/vendors/search?q=' + encodeURIComponent(this.vendor_name))
                    .then(res => res.json())
                    .then(data => this.suggestions = data)
            } else {
                this.suggestions = [];
            }
        },

        fillVendor(v) {
            this.vendor_name = v.vendor_name;
            this.suggestions = [];

            fetch('/vendors/fetch/' + v.id)
            .then(res => res.json())
            .then(data => {

                this.selectedServices = {};
                if (data.service_ids) {
                    data.service_ids.forEach(id => {
                        this.selectedServices[id] = this.serviceLabels[id] ?? 'Unknown';
                    });
                }

                this.starting_price = data.starting_price ?? '';
                this.phone = data.phone ?? '';
                this.email = data.email ?? '';
                this.description = data.description ?? '';
            });
        }
    }
}
</script>

@endsection
