@extends('layouts.userapp')

@section('page-title', 'Dashboard')

@section('content')

@php
    $firstName = explode(' ', trim(auth()->user()->name))[0];
    $wedding   = auth()->user()->weddingDetails;
    $bookings  = auth()->user()->bookings()->with('vendor')->latest()->take(5)->get();
    $totalBookings = auth()->user()->bookings()->count();

    $completedBookings = auth()->user()->bookings()->where('is_completed', 1)->count();
    $pendingBookings   = auth()->user()->bookings()->where('is_completed', 0)->count();

    // NOTE: still using vendor->category for now
    $categoryGroups = auth()->user()->bookings()
    ->with('vendor')
    ->get()
    ->groupBy('vendor.category');

    $categoryLabels = $categoryGroups->keys();

    $categoryValues = $categoryGroups->map(function ($group) {
        return $group->sum(function ($booking) {
            return $booking->vendor->starting_price ?? 0;
        });
    })->values();
@endphp

<div class="p-10">

    {{-- ✅ SUCCESS MODAL --}}
    @if(session('success'))
        <div id="successModal"
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white w-80 p-6 rounded-2xl shadow-xl text-center">
                <h2 class="text-xl font-bold text-green-600 mb-2">Saved Successfully 🎉</h2>
                <p class="text-gray-600 mb-5">
                    Your information has been updated successfully.
                </p>

                <button
                    onclick="document.getElementById('successModal').remove()"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    OK
                </button>
            </div>
        </div>
    @endif

    {{-- ✅ HEADER --}}
    <h1 class="text-3xl font-bold text-rose-900">
        Welcome, {{ $firstName }} 👋
    </h1>
    <p class="text-gray-600 mt-1">Here’s your wedding planning overview</p>

    {{-- ✅ IF NO WEDDING SETUP --}}
    @if(!$wedding)

        <div class="mt-10 bg-white p-8 rounded-xl shadow border border-rose-100">
            <h2 class="text-2xl font-semibold text-rose-900 mb-3">
                Let’s Setup Your Wedding 💍
            </h2>

            <p class="text-gray-700 mb-6">
                Tell us about your wedding so we can personalize your experience.
            </p>

            <a href="{{ url('/wedding/setup') }}"
               class="inline-block px-6 py-3 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                Setup Wedding Details
            </a>
        </div>

    @else

    {{-- ✅ STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

        <div class="bg-white p-6 rounded-xl shadow border border-rose-100">
            <h3 class="text-sm text-gray-500">Your Bookings</h3>
            <p class="text-3xl font-bold text-rose-700 mt-2">
                {{ $totalBookings }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-rose-100">
            <h3 class="text-sm text-gray-500">Wedding Date</h3>
            <p class="text-xl font-semibold mt-2 text-gray-800">
                {{ \Carbon\Carbon::parse($wedding->wedding_date)->format('d M Y') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-rose-100">
            <h3 class="text-sm text-gray-500">Wedding Budget</h3>
            <p class="text-2xl font-bold mt-2 text-rose-700">
                RM {{ number_format($wedding->budget ?? 0, 2) }}
            </p>
        </div>

    </div>

    {{-- ✅ OVERVIEW --}}
    <div class="bg-white p-6 rounded-xl shadow border border-rose-100 mt-10">
        <h2 class="text-xl font-semibold text-rose-900 mb-4">Your Wedding Overview</h2>

        <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-700">
            <div>
                <p><span class="font-semibold">Partner Name:</span> {{ $wedding->partner_name }}</p>
                <p class="mt-2"><span class="font-semibold">Wedding Theme:</span> {{ $wedding->wedding_theme }}</p>
            </div>

            <div>
                <p><span class="font-semibold">Wedding Size:</span> {{ $wedding->wedding_size }}</p>
                <p class="mt-2"><span class="font-semibold">Venue State:</span> {{ $wedding->venue_state }}</p>
            </div>
        </div>
    </div>

    {{-- ✅ CHARTS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">

        <div class="bg-white p-6 rounded-xl shadow border border-rose-100 h-[320px]">
            <h3 class="font-semibold text-rose-900 mb-4">Booking Status</h3>
            <div class="relative h-[220px] w-full">
                <canvas id="bookingStatusChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-rose-100 h-[320px]">
            <h3 class="font-semibold text-rose-900 mb-4">Bookings by Category</h3>
            <div class="relative h-[220px] w-full">
                <canvas id="budgetCategoryChart"></canvas>
            </div>
        </div>


    </div>

    {{-- ✅ RECENT BOOKINGS --}}
    <div class="bg-white p-6 rounded-xl shadow border border-rose-100 mt-10">
        <h2 class="text-xl font-semibold text-rose-900 mb-4">Recent Bookings</h2>

        @if($bookings->count() === 0)
            <p class="text-gray-500 text-sm">You haven’t booked any vendor yet.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-gray-500">
                        <th class="py-3 text-left">Vendor</th>
                        <th class="py-3 text-left">Category</th>
                        <th class="py-3 text-left">Price</th>
                        <th class="py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($bookings as $booking)
                        <tr class="border-b">
                            <td class="py-3 font-medium">
                                {{ $booking->vendor->vendor_name ?? '-' }}
                            </td>
                            <td class="py-3">
                                {{ $booking->vendor->category ?? '-' }}
                            </td>
                            <td class="py-3">
                                RM {{ number_format($booking->vendor->starting_price ?? 0, 2) }}
                            </td>
                            <td class="py-3">
                                @if($booking->is_completed)
                                    <span class="text-green-600 font-semibold">Completed</span>
                                @else
                                    <span class="text-yellow-600 font-semibold">In Progress</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @endif
</div>

{{-- ✅ CHART SCRIPTS --}}
<script>
    // Tunggu semua script & asset siap (termasuk Chart.js)
    window.addEventListener('load', function () {

        if (!window.Chart) {
            console.error('Chart.js not loaded');
            return;
        }

        const bookingCompleted = {{ $completedBookings }};
        const bookingPending   = {{ $pendingBookings }};
        const categoryLabels   = @json($categoryLabels);
        const categoryValues   = @json($categoryValues);

        // ✅ DONUT CHART — SIZE DIKAWAL
        new Chart(document.getElementById('bookingStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress'],
                datasets: [{
                    data: [bookingCompleted, bookingPending],
                    backgroundColor: ['#16a34a', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,   // ✅ PENTING
                cutout: '65%',                 // ✅ Donut cantik
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // ✅ BAR CHART (UNCHANGED)
        new Chart(document.getElementById('budgetCategoryChart'), {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Total Spent (RM)',
                    data: categoryValues,
                    backgroundColor: '#e11d48'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

    });
</script>
@endsection
