<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Farmer Profile') }}
            </h2>
            <a href="{{ route('marketplace.index') }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to Marketplace
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Farmer Info -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center gap-5">
                    @if ($farmer->user->profile_photo_url)
                        <img src="{{ $farmer->user->profile_photo_url }}" alt="{{ $farmer->full_name }}"
                             class="w-20 h-20 rounded-full object-cover border-4 border-accent-500">
                    @else
                        <div class="w-20 h-20 rounded-full bg-primary-50 text-primary-700 border-4 border-accent-500 flex items-center justify-center text-2xl font-semibold">
                            {{ strtoupper(substr($farmer->full_name, 0, 1)) }}
                        </div>
                    @endif

                    <div>
                        <h3 class="text-xl font-semibold">{{ $farmer->full_name }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $farmer->barangay }}@if($farmer->municipality), {{ $farmer->municipality }}@endif
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            ⭐ {{ number_format($farmer->overall_rating, 1) }}
                            ({{ $farmer->total_reviews }} {{ Str::plural('review', $farmer->total_reviews) }})
                            · {{ $farmer->completed_orders }} completed orders
                        </p>
                    </div>
                </div>

                @if ($farmer->commoditiesOffered()->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach ($farmer->commoditiesOffered() as $commodity)
                            <span class="text-xs px-2 py-1 rounded-full bg-primary-50 text-primary-600">
                                {{ $commodity }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Active Listings -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Active Listings</h3>

                @if ($activeProducts->isEmpty())
                    <p class="text-gray-400 text-sm">This farmer has no active listings right now.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ($activeProducts as $product)
                            <a href="{{ route('marketplace.show', $product) }}" class="block border border-primary-600 rounded-lg p-4 hover:shadow-md transition">
                                @if ($product->primaryImage)
                                    <img src="{{ Storage::disk('supabase')->url($product->primaryImage->image_path) }}"
                                         class="w-full h-32 object-cover rounded mb-3">
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded mb-3 flex items-center justify-center text-gray-400 text-sm">
                                        No Image
                                    </div>
                                @endif
                                <p class="text-lg font-bold text-primary-700">
                                    ₱{{ number_format($product->selling_price, 2) }}
                                    <span class="text-xs font-normal text-gray-500">/ {{ $product->unit_of_measurement }}</span>
                                </p>
                                <h4 class="text-sm text-gray-700">{{ $product->product_name }}</h4>
                                <p class="text-xs text-gray-500">{{ $product->commodity_type }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Reviews -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Reviews</h3>

                @if ($reviews->isEmpty())
                    <p class="text-gray-400 text-sm">No reviews yet.</p>
                @else
                    <div class="divide-y">
                        @foreach ($reviews as $review)
                            <div class="py-3">
                                <div class="flex items-center gap-1 mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-accent-500' : 'text-gray-300' }}">★</span>
                                    @endfor
                                    <span class="text-sm text-gray-600 ml-2">{{ $review->buyer->full_name }}</span>
                                </div>
                                @if ($review->comment)
                                    <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>