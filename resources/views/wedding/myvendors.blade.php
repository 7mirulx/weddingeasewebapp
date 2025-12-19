@extends('layouts.userapp')

@section('page-title', 'My Vendors')

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
    $allServices = config('vendor_categories');
    $bookedServiceIds = $bookedServices->toArray();
    $missingServices = collect($allServices)
        ->reject(fn($label, $id) => in_array($id, $bookedServiceIds));

    $completedServices = collect($allServices)
        ->filter(fn($label, $id) => in_array($id, $bookedServiceIds));
@endphp

<div class="max-w-7xl mx-auto relative min-h-screen">
    {{-- BACKGROUND OVERLAY --}}
    <div class="absolute inset-0 bg-center bg-cover bg-no-repeat pointer-events-none z-0 opacity-5"
        style="background-image: url('{{ asset('image/landingoverlay.png') }}');"></div>

    <div class="relative z-10 py-8 px-4">
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
            <div class="bg-white w-full max-w-md mx-auto rounded-xl shadow-2xl z-[99999] p-6 border-l-4 border-green-500">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <h3 class="text-lg font-semibold text-green-800">Success</h3>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">✖</button>
                </div>
                <p class="text-sm text-gray-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- SUCCESS MESSAGE FROM AJAX --}}
        <div id="ajaxSuccessMessage" class="hidden fixed inset-0 flex items-center justify-center z-[9999]">
            <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>
            <div class="bg-white w-full max-w-md mx-auto rounded-xl shadow-2xl z-[99999] p-6 border-l-4 border-green-500">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <h3 class="text-lg font-semibold text-green-800">Vendor Added Successfully!</h3>
                    </div>
                    <button onclick="hideSuccessMessage()" class="text-gray-400 hover:text-gray-600 transition">✖</button>
                </div>
                <p class="text-sm text-gray-700">Your vendor has been added to your bookings.</p>
            </div>
        </div>

        {{-- HEADER SECTION --}}
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-rose-700 mb-2">My Wedding Vendors</h1>
            <p class="text-gray-600 text-lg">Track your ceremony preparation and vendor bookings</p>
        </div>

        {{-- PROGRESS TRACKER CARD --}}
        <div class="mb-10 bg-white border-2 border-pink-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-rose-700 mb-1">Ceremony Prep Progress</h2>
                    <p class="text-gray-600">{{ $bookedCount }} of {{ $totalCategories }} services booked</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-rose-600">{{ $progress }}%</div>
                    <p class="text-sm text-gray-500">Complete</p>
                </div>
            </div>

            {{-- PROGRESS BAR --}}
            <div class="mb-8">
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-rose-400 to-rose-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>
            </div>

            {{-- CHECKLIST ITEMS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- COMPLETED --}}
                @foreach($completedServices as $id => $label)
                    <div class="flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-800">{{ $label }}</span>
                    </div>
                @endforeach

                {{-- MISSING --}}
                @foreach($missingServices as $id => $label)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-300 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-600">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            {{-- ADD VENDOR BUTTON --}}
            @if($missingServices->count())
                <button 
                    onclick="openAddVendorModal()"
                    class="mt-6 w-full bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold py-3 rounded-lg transition shadow-md"
                >
                    + Add Missing Services
                </button>
            @else
                <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg text-center">
                    <p class="text-green-700 font-semibold">🎉 All services booked! Your ceremony is ready!</p>
                </div>
            @endif
        </div>

        {{-- VENDORS GRID --}}
        @if($vendors->count())
            <h2 class="text-2xl font-bold text-rose-700 mb-6">Your Booked Vendors</h2>
            <div id="vendorsContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
                @foreach($vendors as $booking)
                <div class="bg-white border-2 border-pink-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 group">
                    {{-- IMAGE SECTION --}}
                    <div class="relative h-40 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                        <img 
                            src="{{ $booking->vendor->banner_url ? asset('image/'.$booking->vendor->banner_url) : asset('image/vendor-fallback.jpg') }}" 
                            alt="{{ $booking->vendor->vendor_name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                        />
                        {{-- RATING BADGE --}}
                        @if($booking->vendor->rating)
                        <div class="absolute top-3 right-3 bg-white rounded-lg px-3 py-1 shadow-lg flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-bold text-gray-800">{{ $booking->vendor->rating }}/5</span>
                        </div>
                        @endif
                    </div>

                    {{-- CARD HEADER --}}
                    <div class="bg-gradient-to-r from-rose-50 to-pink-50 border-b-2 border-pink-200 p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-rose-700">{{ $booking->vendor->vendor_name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Service Provider</p>
                            </div>
                        </div>

                        {{-- SERVICES TAGS --}}
                        @if ($booking->vendor->service_ids)
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach ($booking->vendor->service_ids as $sid)
                                <span class="px-3 py-1 bg-gradient-to-r from-rose-100 to-pink-100 text-rose-700 rounded-full text-xs font-semibold border border-rose-200">
                                    {{ $services[$sid] ?? 'Unknown' }}
                                </span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- CARD BODY --}}
                    <div class="p-6 space-y-5">
                        {{-- PRICE --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-700 font-semibold">{{ $booking->agreed_price ? 'Agreed Price:' : 'Starting Price:' }}</span>
                            <span class="text-2xl font-bold text-rose-600">RM {{ number_format($booking->agreed_price ?? $booking->vendor->starting_price, 2) }}</span>
                        </div>

                        {{-- PAYMENT STATUS --}}
                        @php
                            $deposit = 0;
                            if ($booking->payment_progress) {
                                $paymentData = is_string($booking->payment_progress) 
                                    ? json_decode($booking->payment_progress, true) 
                                    : (is_array($booking->payment_progress) ? $booking->payment_progress : []);
                                
                                if (is_array($paymentData)) {
                                    $deposit = collect($paymentData)->sum(function($payment) {
                                        return $payment['amount'] ?? 0;
                                    });
                                } else {
                                    $deposit = $paymentData['deposit'] ?? 0;
                                }
                            }
                            $price = $booking->agreed_price ?? $booking->vendor->starting_price ?? 0;
                            $percent = $price > 0 ? round(($deposit / $price) * 100) : 0;
                        @endphp

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Payment Status</span>
                                <span class="text-sm font-bold text-rose-600">{{ $percent }}% Paid</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-rose-400 to-rose-600 h-2 rounded-full transition-all" style="width: {{ $percent }}%"></div>
                            </div>
                            @if($deposit > 0)
                                <p class="text-xs text-gray-600 mt-2">Deposit Paid: <span class="font-semibold">RM {{ number_format($deposit, 2) }}</span></p>
                            @else
                                <p class="text-xs text-red-600 mt-2 font-semibold">⚠️ Payment Not Started</p>
                            @endif
                        </div>

                        {{-- BOOKING STATUS --}}
                        <div class="flex items-center gap-2">
                            @if($booking->is_completed)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full border border-green-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                    Completed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full border border-blue-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 1111.601 2.566V5a1 1 0 11-2 0v-.101a5 5 0 10-9.497 1.087A4.996 4.996 0 1113.961 9H13a1 1 0 110-2h2.101A1 1 0 0116 6V4a1 1 0 11-2 0v.101A7.002 7.002 0 014 5a1 1 0 01-1-1V3a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                    In Progress
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- CARD FOOTER --}}
                    <div class="px-6 py-4 bg-gray-50 border-t-2 border-pink-200 flex justify-end gap-3">
                        {{-- RATE BUTTON --}}
                        @if($booking->is_completed && !$booking->rating)
                        <button 
                            onclick="openRateModal({{ $booking->id }})"
                            class="flex items-center gap-2 px-4 py-2 bg-yellow-50 text-yellow-700 font-semibold rounded-lg hover:bg-yellow-100 transition border border-yellow-300"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.443a1 1 0 00-.364 1.118l1.286 3.947c.3.92-.755 1.688-1.54 1.118l-3.36-2.443a1 1 0 00-1.175 0L5.03 18.0c-.784.57-1.838-.197-1.539-1.118l1.287-3.947a1 1 0 00-.364-1.118L1.05 9.37c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.31-3.943z"/>
                            </svg>
                            Rate
                        </button>
                        @elseif($booking->is_completed && $booking->rating)
                        <button 
                            disabled
                            class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-400 font-semibold rounded-lg cursor-not-allowed border border-gray-300"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.443a1 1 0 00-.364 1.118l1.286 3.947c.3.92-.755 1.688-1.54 1.118l-3.36-2.443a1 1 0 00-1.175 0L5.03 18.0c-.784.57-1.838-.197-1.539-1.118l1.287-3.947a1 1 0 00-.364-1.118L1.05 9.37c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.31-3.943z"/>
                            </svg>
                            Rated
                        </button>
                        @endif

                        {{-- EDIT BUTTON --}}
                        <button 
                            onclick="openEditModal({{ $booking->id }})"
                            class="flex items-center gap-2 px-4 py-2 bg-rose-100 text-rose-700 font-semibold rounded-lg hover:bg-rose-200 transition border border-rose-300"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>

                        {{-- DELETE BUTTON --}}
                        @php
                            $totalPaid = 0;
                            if ($booking->payment_progress) {
                                $paymentData = is_string($booking->payment_progress) 
                                    ? json_decode($booking->payment_progress, true) 
                                    : (is_array($booking->payment_progress) ? $booking->payment_progress : []);
                                
                                if (is_array($paymentData)) {
                                    $totalPaid = collect($paymentData)->sum(function($payment) {
                                        return $payment['amount'] ?? 0;
                                    });
                                } else {
                                    $totalPaid = $paymentData['deposit'] ?? 0;
                                }
                            }
                            $canDelete = $totalPaid == 0;
                        @endphp
                        <button 
                            onclick="openDeleteModal({{ $booking->id }}, '{{ $booking->vendor->vendor_name }}')"
                            {{ !$canDelete ? 'disabled' : '' }}
                            class="flex items-center gap-2 px-4 py-2 {{ $canDelete ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }} font-semibold rounded-lg transition border {{ $canDelete ? 'border-red-300' : 'border-gray-300' }}"
                            title="{{ $canDelete ? '' : 'Cannot delete after payment has been made' }}"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="text-center py-16 px-8 bg-white border-2 border-dashed border-pink-300 rounded-2xl">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No Vendors Booked Yet</h3>
                <p class="text-gray-600 mb-6">Start building your dream wedding team by adding your first vendor</p>
                <button 
                    onclick="openAddVendorModal()"
                    class="bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold py-3 px-8 rounded-lg transition shadow-md"
                >
                    + Add Your First Vendor
                </button>
            </div>
        @endif
    </div>
</div>

{{-- ===================== MODALS ===================== --}}

{{-- RATE MODAL --}}
<div id="rateModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4">
    <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-2xl border-2 border-pink-200">
        <h2 class="text-2xl font-bold text-rose-700 mb-6" id="rateModalTitle">Rate Vendor</h2>

        <form id="rateForm" onsubmit="submitRating(event)" class="space-y-5">
            @csrf
            <input type="hidden" id="bookingId" name="booking_id">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Your Rating</label>
                <select name="rating" required class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition">
                    <option value="">Select a rating...</option>
                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                    <option value="4">⭐⭐⭐⭐ Good</option>
                    <option value="3">⭐⭐⭐ Average</option>
                    <option value="2">⭐⭐ Fair</option>
                    <option value="1">⭐ Poor</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Review (Optional)</label>
                <textarea name="review" rows="4" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition" placeholder="Share your experience..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t-2 border-pink-200">
                <button 
                    type="button"
                    onclick="closeModal('rateModal')"
                    class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition">
                    Submit Rating
                </button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4 overflow-y-auto">
    <div class="bg-white w-full max-w-2xl p-8 rounded-2xl shadow-2xl border-2 border-pink-200 my-auto">
        <h2 class="text-2xl font-bold text-rose-700 mb-6">Edit Booking</h2>

        <form id="editForm" onsubmit="submitEdit(event)" class="space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" id="editBookingId">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Vendor Name</label>
                <input type="text" id="vendorNameDisplay" class="w-full border-2 border-gray-300 rounded-lg p-3 bg-gray-100" readonly>
            </div>

            {{-- PAYMENT HISTORY --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Payment History</label>
                <div id="paymentHistory" class="bg-pink-50 border-2 border-pink-200 rounded-lg p-4 max-h-48 overflow-y-auto mb-4">
                    <p class="text-gray-500 text-sm text-center py-4">No payments recorded yet</p>
                </div>
            </div>

            {{-- ADD NEW PAYMENT --}}
            <div class="border-2 border-pink-200 rounded-lg p-4 bg-white">
                <h3 class="font-semibold text-gray-700 mb-3">Add Payment</h3>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Amount (RM)</label>
                        <input 
                            type="number" 
                            id="paymentAmount"
                            placeholder="0.00"
                            class="w-full border-2 border-pink-200 rounded-lg p-2 text-sm focus:outline-none focus:border-rose-500"
                            step="0.01"
                            min="0"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Date</label>
                        <input 
                            type="date" 
                            id="paymentDate"
                            class="w-full border-2 border-pink-200 rounded-lg p-2 text-sm focus:outline-none focus:border-rose-500"
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
                    <input 
                        type="text" 
                        id="paymentNotes"
                        placeholder="e.g., receipt kept in drive, cheque #123, etc."
                        class="w-full border-2 border-pink-200 rounded-lg p-2 text-sm focus:outline-none focus:border-rose-500"
                    >
                </div>
                <button 
                    type="button"
                    onclick="addPayment()"
                    class="w-full bg-rose-100 text-rose-700 font-semibold py-2 rounded-lg hover:bg-rose-200 transition text-sm"
                >
                    + Add Payment
                </button>
            </div>

            {{-- TOTAL PAID --}}
            <div class="bg-gradient-to-r from-rose-50 to-pink-50 border-2 border-rose-200 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">Total Paid:</span>
                    <span class="text-2xl font-bold text-rose-600">RM <span id="totalPaidDisplay">0.00</span></span>
                </div>
            </div>

            {{-- AGREED PRICE --}}
            <div class="bg-white border-2 border-pink-200 rounded-lg p-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Agreed Price (RM)</label>
                <input type="number" name="agreed_price" id="agreedPriceInput" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition" step="0.01" min="0">
            </div>

            {{-- BOOKING STATUS --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Booking Status</label>
                <div id="statusDisplay" class="w-full border-2 border-pink-200 rounded-lg p-3 bg-gray-50 flex items-center gap-2">
                    <span id="statusIcon">📋</span>
                    <span id="statusText" class="font-semibold text-gray-700">In Progress</span>
                </div>
                <input type="hidden" name="is_completed" id="statusValue" value="0">
                <p class="text-xs text-gray-500 mt-2">Status updates automatically when full payment is made</p>
            </div>

            <input type="hidden" name="payment_progress" id="paymentProgressInput" value="[]">

            <div class="flex justify-end gap-3 pt-4 border-t-2 border-pink-200">
                <button 
                    type="button"
                    onclick="closeModal('editModal')"
                    class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-rose-500 to-rose-600 text-white font-semibold rounded-lg hover:from-rose-600 hover:to-rose-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE CONFIRMATION MODAL --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4">
    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl border-2 border-red-200">
        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">Remove Vendor</h3>
        <p class="text-gray-600 text-center mb-6">
            Are you sure you want to remove <span class="font-semibold" id="vendorNameToDelete">this vendor</span>? This action cannot be undone.
        </p>

        <div class="flex justify-end gap-3">
            <button 
                type="button"
                onclick="closeModal('deleteModal')"
                class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition"
            >
                Cancel
            </button>
            <button 
                type="button"
                onclick="confirmDelete()"
                class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-lg hover:from-red-600 hover:to-red-700 transition"
            >
                Remove
            </button>
        </div>
    </div>
</div>

{{-- ADD VENDOR MODAL --}}
<div id="addVendorModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] p-4 overflow-y-auto"
    x-data="vendorForm()">
    <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-2xl border-2 border-pink-200 my-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-rose-700">Add Vendor</h2>
            <button onclick="closeModal('addVendorModal')" class="text-gray-400 hover:text-gray-600">✖</button>
        </div>

        <form id="addVendorForm" onsubmit="submitAddVendor(event)" autocomplete="off" class="space-y-5">
            @csrf

            {{-- VENDOR SEARCH --}}
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Vendor Name</label>
                <input
                    type="text"
                    name="vendor_name"
                    id="vendorNameInput"
                    x-model="vendor_name"
                    @input="selectedVendor = null; searchVendors()"
                    :readonly="selectedVendor !== null"
                    class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition readonly:bg-gray-100 readonly:cursor-not-allowed"
                    placeholder="Search or type vendor name..."
                    autocomplete="off"
                >

                <div
                    x-show="suggestions.length"
                    @click.outside="suggestions = []"
                    class="absolute left-0 right-0 bg-white border-2 border-pink-200 rounded-lg mt-2 shadow-lg z-[99999] max-h-48 overflow-y-auto"
                >
                    <template x-for="v in suggestions" :key="v.id">
                        <div
                            class="px-4 py-3 hover:bg-rose-50 cursor-pointer border-b border-gray-100 last:border-0"
                            @click="fillVendor(v)"
                        >
                            <div class="font-semibold text-gray-800" x-text="v.vendor_name"></div>
                            <div class="text-gray-500 text-sm mt-1">Starting from RM <span x-text="(v.starting_price ?? 0).toFixed(2)"></span></div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- CATEGORIES MULTISELECT --}}
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Services (Select Multiple)</label>

                <div 
                    @click="selectedVendor === null && (catOpen = !catOpen)"
                    :class="selectedVendor !== null ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'cursor-pointer'"
                    class="w-full border-2 border-pink-200 rounded-lg p-3 bg-white flex flex-col gap-2 min-h-[60px] focus-within:border-rose-500 transition"
                >
                    <template x-for="(label, id) in selectedServices" :key="id">
                        <div class="flex justify-between items-center px-3 py-2 bg-gradient-to-r from-rose-100 to-pink-100 text-rose-700 text-sm font-semibold rounded-md shadow-sm border border-rose-200">
                            <span x-text="label"></span>
                            <button 
                                type="button"
                                @click.stop="delete selectedServices[id]"
                                class="text-rose-600 hover:text-rose-900 font-bold">
                                ✕
                            </button>
                        </div>
                    </template>

                    <span 
                        x-show="Object.keys(selectedServices).length === 0" 
                        class="text-gray-500 text-sm">
                        Click to select services...
                    </span>
                </div>

                <div
                    x-show="catOpen"
                    @click.outside="catOpen = false"
                    class="absolute bg-white border-2 border-pink-200 rounded-lg mt-2 w-full shadow-xl max-h-56 overflow-y-auto z-[99999] p-2"
                >
                    @foreach ($services as $id => $label)
                    <div 
                        class="flex items-center gap-3 px-3 py-2 hover:bg-rose-50 rounded cursor-pointer"
                        @click="
                            if (selectedServices[{{ $id }}]) {
                                delete selectedServices[{{ $id }}];
                            } else {
                                selectedServices[{{ $id }}] = '{{ $label }}';
                            }
                        "
                    >
                        <input type="checkbox" class="w-4 h-4 text-rose-600 rounded" :checked="selectedServices[{{ $id }}]">
                        <span class="text-gray-700">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>

                <template x-for="(label, id) in selectedServices" :key="'hidden-'+id">
                    <input type="hidden" name="service_ids[]" :value="id">
                </template>
            </div>

            {{-- VENDOR DETAILS --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Starting Price (RM)</label>
                    <input type="number" name="starting_price" x-model="starting_price" :readonly="selectedVendor !== null" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition readonly:bg-gray-100 readonly:cursor-not-allowed" step="0.01">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                    <input type="text" name="phone" x-model="phone" :readonly="selectedVendor !== null" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition readonly:bg-gray-100 readonly:cursor-not-allowed">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" x-model="email" :readonly="selectedVendor !== null" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition readonly:bg-gray-100 readonly:cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" x-model="description" :readonly="selectedVendor !== null" rows="3" class="w-full border-2 border-pink-200 rounded-lg p-3 focus:outline-none focus:border-rose-500 transition readonly:bg-gray-100 readonly:cursor-not-allowed" placeholder="Brief description of services..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t-2 border-pink-200">
                <button 
                    type="button"
                    @click="clearForm(); closeModal('addVendorModal')"
                    class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                <button type="submit" id="addVendorSubmitBtn" class="px-6 py-2 bg-gradient-to-r from-rose-500 to-rose-600 text-white font-semibold rounded-lg hover:from-rose-600 hover:to-rose-700 transition">
                    Add Vendor
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ===================== MODAL FUNCTIONS =====================
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function openAddVendorModal() {
    openModal('addVendorModal');
}

// ===================== RATE FUNCTIONS =====================
function openRateModal(bookingId) {
    document.getElementById('bookingId').value = bookingId;
    openModal('rateModal');
}

function submitRating(e) {
    e.preventDefault();
    const bookingId = document.getElementById('bookingId').value;
    const formData = new FormData(document.getElementById('rateForm'));
    
    fetch(`/myvendors/rate/${bookingId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeModal('rateModal');
            location.reload();
        } else if (data.errors) {
            // Handle validation errors
            alert('Error: ' + Object.values(data.errors).flat().join(', '));
        } else if (data.message) {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => alert('Error: ' + err));
}

// ===================== EDIT FUNCTIONS =====================
let currentEditBookingId = null;
let vendorsData = @json($vendors);

let currentPayments = [];

function openEditModal(bookingId) {
    currentEditBookingId = bookingId;
    const booking = vendorsData.find(b => b.id === bookingId);
    
    if (booking) {
        document.getElementById('editBookingId').value = bookingId;
        document.getElementById('vendorNameDisplay').value = booking.vendor.vendor_name;
        document.getElementById('agreedPriceInput').value = booking.agreed_price || '';
        
        // Load existing payments - convert object format to array if needed
        if (booking.payment_progress) {
            let paymentData = booking.payment_progress;
            
            // If it's a string, parse it
            if (typeof paymentData === 'string') {
                try {
                    paymentData = JSON.parse(paymentData);
                } catch (e) {
                    paymentData = [];
                }
            }
            
            // If it's an array, use it directly
            if (Array.isArray(paymentData)) {
                currentPayments = paymentData;
            } else {
                // Convert object format to array format
                currentPayments = Object.entries(paymentData)
                    .filter(([key, value]) => value !== null && value !== undefined && value !== 0)
                    .map(([key, value]) => ({
                        amount: parseFloat(value) || 0,
                        date: new Date().toISOString().split('T')[0],
                        notes: key
                    }));
            }
        } else {
            currentPayments = [];
        }
        renderPaymentHistory();
        
        // Update status display
        updateStatusDisplay();
        
        openModal('editModal');
    }
}

function addPayment() {
    const amount = parseFloat(document.getElementById('paymentAmount').value);
    const date = document.getElementById('paymentDate').value;
    const notes = document.getElementById('paymentNotes').value;
    
    if (!amount || amount <= 0) {
        alert('Please enter a valid amount');
        return;
    }
    if (!date) {
        alert('Please select a date');
        return;
    }
    
    currentPayments.push({
        amount: amount,
        date: date,
        notes: notes
    });
    
    // Clear inputs
    document.getElementById('paymentAmount').value = '';
    document.getElementById('paymentDate').value = '';
    document.getElementById('paymentNotes').value = '';
    
    renderPaymentHistory();
}

function updateStatusDisplay() {
    const bookingId = document.getElementById('editBookingId').value;
    const booking = vendorsData.find(b => b.id == bookingId);
    const totalPaid = currentPayments.reduce((sum, p) => sum + p.amount, 0);
    const agreedPrice = parseFloat(document.getElementById('agreedPriceInput').value) || 0;
    const startingPrice = booking?.vendor?.starting_price || 0;
    const comparePrice = agreedPrice > 0 ? agreedPrice : startingPrice;
    
    const isCompleted = comparePrice > 0 && totalPaid >= comparePrice;
    const statusIcon = document.getElementById('statusIcon');
    const statusText = document.getElementById('statusText');
    const statusValue = document.getElementById('statusValue');
    
    if (isCompleted) {
        statusIcon.textContent = '✅';
        statusText.textContent = 'Completed';
        statusValue.value = '1';
    } else {
        statusIcon.textContent = '📋';
        statusText.textContent = 'In Progress';
        statusValue.value = '0';
    }
}

function removePayment(index) {
    currentPayments.splice(index, 1);
    renderPaymentHistory();
}

document.addEventListener('DOMContentLoaded', function() {
    const agreedPriceInput = document.getElementById('agreedPriceInput');
    if (agreedPriceInput) {
        agreedPriceInput.addEventListener('change', updateStatusDisplay);
    }
});

function renderPaymentHistory() {
    const historyDiv = document.getElementById('paymentHistory');
    const totalPaidSpan = document.getElementById('totalPaidDisplay');
    const paymentProgressInput = document.getElementById('paymentProgressInput');
    
    if (currentPayments.length === 0) {
        historyDiv.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">No payments recorded yet</p>';
        totalPaidSpan.textContent = '0.00';
        paymentProgressInput.value = '[]';
        return;
    }
    
    let total = 0;
    let html = '';
    
    currentPayments.forEach((payment, index) => {
        const amount = typeof payment.amount === 'string' ? parseFloat(payment.amount) : payment.amount;
        total += amount || 0;
        const paymentDate = new Date(payment.date).toLocaleDateString('en-MY');
        html += `
            <div class="bg-white border border-pink-200 rounded-lg p-3 mb-2 flex justify-between items-start">
                <div class="flex-1">
                    <div class="font-semibold text-rose-600">RM ${(amount || 0).toFixed(2)}</div>
                    <div class="text-xs text-gray-500">${paymentDate}</div>
                    ${payment.notes ? `<div class="text-xs text-gray-600 mt-1">📝 ${payment.notes}</div>` : ''}
                </div>
                <button 
                    type="button"
                    onclick="removePayment(${index})"
                    class="text-red-500 hover:text-red-700 font-bold ml-2"
                >
                    ✕
                </button>
            </div>
        `;
    });
    
    historyDiv.innerHTML = html;
    totalPaidSpan.textContent = total.toFixed(2);
    paymentProgressInput.value = JSON.stringify(currentPayments);
    
    // Update status display when payments change
    updateStatusDisplay();
}

function submitEdit(e) {
    e.preventDefault();
    const bookingId = document.getElementById('editBookingId').value;
    const booking = vendorsData.find(b => b.id === bookingId);
    const totalPaid = currentPayments.reduce((sum, p) => sum + p.amount, 0);
    const agreedPrice = parseFloat(document.getElementById('agreedPriceInput').value) || 0;
    const startingPrice = booking?.vendor?.starting_price || 0;
    const comparePrice = agreedPrice > 0 ? agreedPrice : startingPrice;
    
    const formData = new FormData(document.getElementById('editForm'));
    formData.set('payment_progress', JSON.stringify(currentPayments));
    formData.set('agreed_price', agreedPrice);
    
    // Auto-mark as completed if full payment is made
    // HERE - is_completed status is updated based on payment completion
    if (totalPaid >= comparePrice && comparePrice > 0) {
        formData.set('is_completed', '1');
        document.getElementById('statusValue').value = '1';
    } else {
        formData.set('is_completed', '0');
        document.getElementById('statusValue').value = '0';
    }
    
    fetch(`/myvendors/update/${bookingId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeModal('editModal');
            location.reload();
        } else if (data.errors) {
            alert('Error: ' + Object.values(data.errors).flat().join(', '));
        } else if (data.message) {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => alert('Error: ' + err));
}

// ===================== DELETE FUNCTIONS =====================
let currentDeleteBookingId = null;

function openDeleteModal(bookingId, vendorName) {
    currentDeleteBookingId = bookingId;
    document.getElementById('vendorNameToDelete').textContent = vendorName;
    openModal('deleteModal');
}

function confirmDelete() {
    if (!currentDeleteBookingId) return;
    
    fetch(`/myvendors/delete/${currentDeleteBookingId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success || data.status === 'success') {
            closeModal('deleteModal');
            location.reload();
        } else if (data.errors) {
            alert('Error: ' + Object.values(data.errors).flat().join(', '));
        } else if (data.message) {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => alert('Error: ' + err));
}

// ===================== ADD VENDOR FUNCTIONS =====================
function submitAddVendor(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('addVendorSubmitBtn');
    const formData = new FormData(document.getElementById('addVendorForm'));
    
    // Disable button to prevent double submission
    submitBtn.disabled = true;
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Adding...';
    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    
    fetch('/myvendors/add', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            closeModal('addVendorModal');
            showSuccessMessage();
            setTimeout(() => location.reload(), 1500);
        } else {
            // Re-enable button on error
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            alert('Error: ' + (data.message || 'Failed to add vendor'));
        }
    })
    .catch(err => {
        // Re-enable button on error
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        alert('Error: ' + err);
    });
}

function showSuccessMessage() {
    const msg = document.getElementById('ajaxSuccessMessage');
    msg.classList.remove('hidden');
}

function hideSuccessMessage() {
    document.getElementById('ajaxSuccessMessage').classList.add('hidden');
}

// ===================== VENDOR FORM =====================
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
            this.selectedVendor = v.id;  // Mark as selected from database
            this.vendor_name = v.vendor_name;
            this.suggestions = [];
            this.starting_price = v.starting_price ?? '';
            this.phone = v.phone ?? '';
            this.email = v.email ?? '';
            this.description = v.description ?? '';
            this.selectedServices = {};
            if (v.service_ids) {
                v.service_ids.forEach(id => {
                    this.selectedServices[id] = this.serviceLabels[id] ?? 'Unknown';
                });
            }
        },

        clearForm() {
            this.selectedVendor = null;
            this.vendor_name = '';
            this.suggestions = [];
            this.selectedServices = {};
            this.catOpen = false;
            this.starting_price = '';
            this.phone = '';
            this.email = '';
            this.description = '';
        }
    }
}
</script>

@endsection
