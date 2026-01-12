@extends('layouts.vendor')

@section('page-title', 'Reviews & Ratings')

@section('content')
<div class="space-y-6">
    <!-- Rating Summary -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">Reviews & Ratings</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Average Rating -->
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-6 text-center">
                <p class="text-gray-600 text-sm mb-2">Average Rating</p>
                <div class="text-4xl font-bold text-indigo-600">{{ number_format($vendor->rating_average, 1) }}</div>
                <div class="flex justify-center gap-1 mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= floor($vendor->rating_average) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
            </div>

            <!-- Total Reviews -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center">
                <p class="text-gray-600 text-sm mb-2">Total Reviews</p>
                <div class="text-4xl font-bold text-blue-600">{{ $vendor->rating_count }}</div>
            </div>

            <!-- Review Rate -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center">
                <p class="text-gray-600 text-sm mb-2">Review Rate</p>
                <div class="text-4xl font-bold text-green-600">{{ $vendor->rating_count > 0 ? round(($vendor->rating_count / max($vendor->rating_count, 1)) * 100) : 0 }}%</div>
                <p class="text-sm text-gray-600 mt-1">of clients reviewed</p>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h3 class="text-xl font-bold text-indigo-700 mb-6">Client Reviews</h3>

        @if($reviews->count() > 0)
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="border-l-4 border-indigo-500 pl-6 pb-6 border-b last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $review->review ?? 'No review provided' }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            @endif
        @else
            <div class="p-8 bg-gray-50 rounded-lg text-center">
                <p class="text-gray-500">No reviews yet</p>
                <p class="text-gray-400 text-sm mt-2">When clients book and complete your service, they can leave reviews</p>
            </div>
        @endif
    </div>
</div>
@endsection
