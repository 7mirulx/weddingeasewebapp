@extends('layouts.publicapp')

@section('page-title', 'Claim Your Business')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-pink-50 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Claim Your Business</h1>
            <p class="text-lg text-gray-600">Connect your wedding vendor business to Jom Kahwin and start managing bookings directly.</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ session('error') }}
        </div>
        @endif

        {{-- Main Content --}}
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            {{-- Benefits --}}
            <div class="bg-white rounded-xl shadow-lg p-8 border-2 border-pink-100">
                <h2 class="text-2xl font-bold text-rose-700 mb-6">Why Claim Your Business?</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-rose-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Manage Bookings</h3>
                            <p class="text-gray-600 text-sm">Track and manage all your wedding bookings from one dashboard.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-rose-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">View Ratings</h3>
                            <p class="text-gray-600 text-sm">See reviews and ratings from your clients.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-rose-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Increase Visibility</h3>
                            <p class="text-gray-600 text-sm">Improve your profile visibility on Jom Kahwin.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-rose-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">24/7 Support</h3>
                            <p class="text-gray-600 text-sm">Get dedicated support for your vendor business.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- How It Works --}}
            <div class="bg-white rounded-xl shadow-lg p-8 border-2 border-pink-100">
                <h2 class="text-2xl font-bold text-rose-700 mb-6">How It Works</h2>
                
                <div class="space-y-6">
                    <div class="relative pl-8">
                        <div class="absolute left-0 top-1 bg-rose-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm">1</div>
                        <h3 class="font-semibold text-gray-900">Check Your Email</h3>
                        <p class="text-gray-600 text-sm">You should have received a claim invitation email.</p>
                    </div>

                    <div class="relative pl-8">
                        <div class="absolute left-0 top-1 bg-rose-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm">2</div>
                        <h3 class="font-semibold text-gray-900">Click the Link</h3>
                        <p class="text-gray-600 text-sm">Click the claim link in your email to get started.</p>
                    </div>

                    <div class="relative pl-8">
                        <div class="absolute left-0 top-1 bg-rose-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm">3</div>
                        <h3 class="font-semibold text-gray-900">Create Your Account</h3>
                        <p class="text-gray-600 text-sm">Register a new vendor account to claim your business.</p>
                    </div>

                    <div class="relative pl-8">
                        <div class="absolute left-0 top-1 bg-rose-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm">4</div>
                        <h3 class="font-semibold text-gray-900">Complete Payment</h3>
                        <p class="text-gray-600 text-sm">Process the activation fee to finalize your claim.</p>
                    </div>

                    <div class="relative pl-8">
                        <div class="absolute left-0 top-1 bg-rose-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-sm">5</div>
                        <h3 class="font-semibold text-gray-900">Done!</h3>
                        <p class="text-gray-600 text-sm">Your business is now claimed and ready to manage.</p>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 text-sm">
                    <p><strong>Note:</strong> You need a valid claim token from your invitation email to proceed.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-gradient-to-r from-rose-500 to-rose-600 rounded-xl shadow-lg p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-3">Don't have an invitation yet?</h2>
            <p class="mb-6">Contact Jom Kahwin to claim your business or if you believe you should have received an invitation.</p>
            <a href="mailto:support@jomkahwin.com" class="inline-block bg-white text-rose-600 font-semibold px-8 py-3 rounded-lg hover:bg-rose-50 transition">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
