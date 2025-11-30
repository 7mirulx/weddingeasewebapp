@extends('layouts.userapp')

@section('content')
<div>

    <div class="min-h-screen flex justify-center items-center px-4">

        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-xl w-full">
            <!-- FORM CONTENT STARTS -->
            
            <h1 class="text-2xl font-bold text-rose-900 mb-4">
                Setup Your Wedding Details 💍
            </h1>

            <p class="text-gray-700 mb-6 text-sm">
                Tell us a bit about your wedding so we can personalize your experience.
            </p>

            <form action="{{ url('/wedding/setup') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Partner Name --}}
                    <div>
                        <label class="block text-gray-700 mb-1 font-medium text-sm">Partner's Name</label>
                        <input type="text" name="partner_name"
                            class="w-full p-2 border rounded-lg text-sm"
                            placeholder="e.g. Atiqah Firman">
                    </div>

                    {{-- Wedding Date --}}
                    <div>
                        <label class="block text-gray-700 mb-1 font-medium text-sm">Wedding Date</label>
                        <input type="date" name="wedding_date"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Preference Priority --}}
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 mb-1 font-medium text-sm">What Do You Value Most?</label>
                        <select name="preference_priority" class="w-full p-2 border rounded-lg text-sm">
                            <option value="balanced">Balanced</option>
                            <option value="budget">Budget-Friendly</option>
                            <option value="quality">High Quality</option>
                            <option value="service">Best Service</option>
                            <option value="popularity">Popular Vendors</option>
                        </select>
                    </div>

                    {{-- Wedding Theme --}}
                    <div>
                        <label class="block text-gray-700 mb-1 font-medium text-sm">Wedding Theme</label>

                        <select name="wedding_theme"
                            class="w-full p-2 rounded-lg border text-sm bg-white focus:ring-2 focus:ring-rose-300 focus:border-rose-400 transition">

                            <option disabled selected>Select a theme</option>
                            <option value="modern_minimalist">Modern Minimalist</option>
                            <option value="rustic_vintage">Rustic Vintage</option>
                            <option value="garden">Garden Inspired</option>
                            <option value="classic_ballroom">Classic Ballroom</option>
                            <option value="luxury_glam">Luxury Glam</option>
                            <option value="bohemian">Bohemian</option>
                            <option value="traditional_malay">Traditional Malay</option>
                        </select>
                    </div>


                    {{-- Size --}}
                    <div>
                        <label class="block text-gray-700 mb-1 font-medium text-sm">Wedding Size (pax)</label>
                        <input type="number" name="wedding_size"
                            placeholder="e.g. 300"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Budget --}}
                    <div>
                        <label class="block text-gray-700 mb-1 font-medium text-sm">Budget (RM)</label>
                        <input type="number" name="budget"
                            placeholder="e.g. 15000"
                            class="w-full p-2 border rounded-lg text-sm">
                    </div>

                    {{-- Venue Area --}}
                    <div>
                        <label class="block text-gray-700 mb-1 font-medium text-sm">Venue Area / State</label>
                        <select name="venue_state" class="w-full p-2 border rounded-lg text-sm">
                            <option value="" disabled selected>Select area / state</option>
                            <option value="klang_valley">Klang Valley</option>

                            <option value="selangor">Selangor</option>
                            <option value="kuala_lumpur">Kuala Lumpur</option>
                            <option value="putrajaya">Putrajaya</option>

                            <option value="johor">Johor</option>
                            <option value="kedah">Kedah</option>
                            <option value="kelantan">Kelantan</option>
                            <option value="melaka">Melaka</option>
                            <option value="negeri_sembilan">Negeri Sembilan</option>
                            <option value="pahang">Pahang</option>
                            <option value="perak">Perak</option>
                            <option value="perlis">Perlis</option>
                            <option value="pulau_pinang">Pulau Pinang</option>
                            <option value="sabah">Sabah</option>
                            <option value="sarawak">Sarawak</option>
                            <option value="terengganu">Terengganu</option>
                        </select>

                    </div>

                </div>

                <button type="submit"
                    class="px-6 py-2 bg-pink-400 text-white text-sm font-semibold rounded-lg hover:bg-pink-500 transition">
                    Save
                </button>

            </form>
            <!-- FORM CONTENT ENDS -->
        </div>

    </div>


</div>
@endsection
