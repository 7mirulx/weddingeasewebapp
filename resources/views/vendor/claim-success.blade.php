@extends('layouts.userapp')

@section('page-title', 'Claim Successful')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-pink-50 py-12 px-4 flex items-center justify-center">
    <div class="max-w-2xl w-full">
        {{-- Success Card --}}
        <div class="bg-white rounded-xl shadow-lg border-2 border-pink-200 p-8 text-center">
            {{-- Success Icon --}}
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
                <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>

            {{-- Heading --}}
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Congratulations!</h1>
            <p class="text-lg text-gray-600 mb-8">Your vendor business has been successfully claimed.</p>

            {{-- Details --}}
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="font-semibold text-gray-900 mb-4">Business Details</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Business Name:</span>
                        <span class="font-semibold text-gray-900">{{ $vendor->vendor_name }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Category:</span>
                        <span class="font-semibold text-gray-900">{{ $vendor->category }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Location:</span>
                        <span class="font-semibold text-gray-900">{{ $vendor->city }}, {{ $vendor->state }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-block bg-blue-100 text-blue-700 font-semibold px-3 py-1 rounded-full text-sm">
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Next Steps --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 text-left">
                <h3 class="font-semibold text-gray-900 mb-4">What's Next?</h3>
                
                <ol class="space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</span>
                        <span>Complete your vendor profile with photos and services</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</span>
                        <span>Set up your pricing and availability</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</span>
                        <span>Start receiving and managing bookings</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">4</span>
                        <span>Build your reputation through excellent service</span>
                    </li>
                </ol>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('vendor.dashboard') }}" class="px-8 py-3 bg-gradient-to-r from-rose-500 to-rose-600 text-white font-semibold rounded-lg hover:from-rose-600 hover:to-rose-700 transition inline-block">
                    Go to Vendor Dashboard
                </a>
                <a href="{{ route('home') }}" class="px-8 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition inline-block">
                    Back to Home
                </a>
            </div>

            {{-- Support --}}
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Need help? Contact our support team at
                    <a href="mailto:support@jomkahwin.com" class="text-rose-600 hover:underline">support@jomkahwin.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
