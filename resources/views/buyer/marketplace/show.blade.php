<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->product_name }}
            </h2>
            <a href="{{ route('marketplace.index') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Back to Marketplace
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
                        <p class="text-2xl font-bold mb-1">₱{{ number_format($product->selling_price, 2) }} <span class="text-base font-normal text-gray-500">/ {{ $product->unit_of_measurement }}</span></p>
                        <p class="text-gray-500 mb-4">{{ $product->commodity_type }} — {{ $product->category }}@if($product->variety) ({{ $product->variety }})@endif</p>

                        @if ($product->description)
                            <p class="text-gray-700 mb-6">{{ $product->description }}</p>
                        @endif

                        <!-- Farmer Info -->
                        <div class="border rounded-lg p-4 mb-6 bg-gray-50">
                            <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2">Sold by</h3>
                            <p class="font-medium">{{ $product->farmer->full_name }}</p>
                            <p class="text-sm text-gray-500">{{ $product->farmer->barangay }}, {{ $product->farmer->municipality }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                ⭐ {{ number_format($product->farmer->overall_rating, 1) }}
                                ({{ $product->farmer->total_reviews }} {{ Str::plural('review', $product->farmer->total_reviews) }})
                                · {{ $product->farmer->completed_orders }} completed orders
                            </p>
                        </div>

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
                        <div class="grid grid-cols-2 gap-2 text-sm mb-6">
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

                        <!-- Actions -->
<div x-data="{ quantity: {{ $product->minimum_order_quantity ?? 1 }}, price: {{ $product->selling_price }} }">
    <div class="mb-3">
        <label class="block text-xs text-gray-500 mb-1">Quantity ({{ $product->unit_of_measurement }})</label>
        <input type="number" x-model.number="quantity" min="0.01" step="0.01"
            class="w-24 border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
        <p class="text-sm text-gray-600 mt-1">
            Total: <span class="font-semibold text-gray-900" x-text="'₱' + (quantity * price).toFixed(2)"></span>
        </p>
    </div>

    <div class="flex gap-3">
        <form method="POST" action="{{ route('cart.buyNow', $product) }}" class="flex-1">
            @csrf
            <input type="hidden" name="quantity" :value="quantity">
            <button type="submit" class="w-full bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md transition">
                Buy Now
            </button>
        </form>

        <form method="POST" action="{{ route('cart.store', $product) }}" class="flex-1">
            @csrf
            <input type="hidden" name="quantity" :value="quantity">
            <button type="submit" class="w-full border border-primary-600 text-primary-600 hover:bg-primary-50 font-semibold px-4 py-2 rounded-md transition">
                Add to Cart
            </button>
        </form>

        <a href="{{ route('messages.show', $product->farmer->user_id) }}"
           class="flex-1 text-center border border-primary-600 text-primary-600 hover:bg-primary-50 font-semibold px-4 py-2 rounded-md flex items-center justify-center">
            Chat with Farmer
        </a>
    </div>
</div>
</form>
</x-app-layout>