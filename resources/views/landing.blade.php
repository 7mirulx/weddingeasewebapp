@extends('layouts.publicapp')

@section('content')

<div class="relative overflow-hidden">
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
        <div class="py-12">
            <h1 class="text-4xl lg:text-5xl font-semibold mb-4">Plan your perfect wedding with ease</h1>
            <p class="text-lg dark:text-gray-900 mb-6">WeddingEase helps couples and vendors coordinate every detail — guest lists, timelines, budgets and more — in one simple app.</p>

            <div class="flex gap-3">
                <a href="{{ route('register') }}" class="inline-block px-6 py-3 btn-primary rounded-md">Get started — it’s free</a>
                <a href="#features" class="inline-block px-6 py-3 border border-gray-200 rounded-md btn-alt">Learn more</a>
            </div>

            <ul id="features" class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <li class="bg-white p-4 rounded-md shadow">Guest list & RSVPs</li>
                <li class="bg-white p-4 rounded-md shadow">Budget tracking</li>
                <li class="bg-white p-4 rounded-md shadow">Vendor management</li>
                <li class="bg-white p-4 rounded-md shadow">Timeline & reminders</li>
            </ul>
        </div>

        <div class="py-12 flex items-center justify-center">
            <div class="w-full max-w-md bg-brand2 rounded-lg p-6">
                <h3 class="font-medium mb-3">Start a new plan</h3>
                <p class="text-sm dark:text-gray-900 mb-4">Create your wedding plan and invite your partner.</p>
                <a href="{{ route('register') }}" class="block px-4 py-2 btn-primary rounded-md text-center">Create plan</a>
            </div>
        </div>
    </section>

</div>
<!-- <div class="absolute bottom-0 left-0 w-full h-[350px] bg-cover bg-bottom opacity-25 pointer-events-none" style="background-image: url('{{ asset('image/landingoverlay.png') }}')"></div> -->
@endsection
