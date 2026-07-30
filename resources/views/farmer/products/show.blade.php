<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->product_name }}
            </h2>
            <a href="{{ route('farmer.products.index') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Back to My Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Images -->
                    <div>
                        @if ($product->images->isNotEmpty())
                            <img src="{{ Storage::url($product->images->firstWhere('is_primary', true)?->image_path ?? $product->images->first()->image_path) }}"
                                 class="w-full h-80 object-cover rounded-lg mb-3">

                            @if ($product->images->count() > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ($product->images as $image)
                                        <img src="{{ Storage::url($image->image_path) }}"
                                             class="w-full h-20 object-cover rounded border">
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="w-full h-80 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div>
                        <span class="inline-block text-xs px-2 py-1 rounded-full mb-3
                            {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($product->status) }}
                        </span>

                        <p class="text-2xl font-bold mb-1">₱{{ number_format($product->selling_price, 2) }} <span class="text-base font-normal text-gray-500">/ {{ $product->unit_of_measurement }}</span></p>
                        <p class="text-gray-500 mb-4">{{ $product->commodity_type }} — {{ $product->category }}@if($product->variety) ({{ $product->variety }})@endif</p>

                        @if ($product->description)
                            <p class="text-gray-700 mb-6">{{ $product->description }}</p>
                        @endif

                        <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2">Stock</h3>
                        <p class="mb-1">Available Quantity: <strong>{{ $product->available_quantity }} {{ $product->unit_of_measurement }}</strong></p>
                        @if ($product->minimum_order_quantity)
                            <p class="mb-4">Minimum Order: <strong>{{ $product->minimum_order_quantity }} {{ $product->unit_of_measurement }}</strong></p>
                        @endif

                        <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2 mt-4">Harvest Information</h3>
                        <p class="mb-1">Harvest Date: <strong>{{ $product->harvest_date->format('F d, Y') }}</strong></p>
                        <p class="mb-1">Freshness: <strong>{{ $product->freshness_status }}</strong></p>
                        @if ($product->estimated_shelf_life_days)
                            <p class="mb-4">Estimated Shelf Life: <strong>{{ $product->estimated_shelf_life_days }} days</strong></p>
                        @endif

                        <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2 mt-4">Product Quality</h3>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            @if ($product->product_grade)
                                <p>Grade: <strong>{{ $product->product_grade }}</strong></p>
                            @endif
                            @if ($product->product_condition)
                                <p>Condition: <strong>{{ $product->product_condition }}</strong></p>
                            @endif
                            @if ($product->production_method)
                                <p>Production Method: <strong>{{ $product->production_method }}</strong></p>
                            @endif
                            @if ($product->size_weight_classification)
                                <p>Size/Weight: <strong>{{ $product->size_weight_classification }}</strong></p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t mt-8 pt-6">
                    <h3 class="font-semibold text-sm text-gray-500 uppercase mb-4">
    Reviews ({{ $reviews->count() }})
</h3>

@forelse ($reviews as $review)
                        <div class="border-b pb-4 mb-4 last:border-b-0">
                            <div class="flex justify-between items-start">
                                <p class="font-medium">{{ $review->buyer->full_name }}</p>
                                <div class="flex gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-accent-500' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            @if ($review->comment)
                                <p class="text-sm text-gray-600 mt-1">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No reviews yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>