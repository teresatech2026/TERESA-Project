<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->product_name }}
            </h2>
            <a href="{{ route('marketplace.index') }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to Marketplace
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Images -->
                    <div x-data="{ activeImage: '{{ $product->images->firstWhere('is_primary', true)?->image_path ?? $product->images->first()?->image_path }}' }">
                        @if ($product->images->isNotEmpty())
                            <img :src="'{{ Storage::disk('supabase')->url('') }}' + activeImage"
                                 class="w-full h-80 object-cover rounded-lg mb-3">

                            @if ($product->images->count() > 1)
                                <div class="flex gap-2 overflow-x-auto pb-2">
                                    @foreach ($product->images as $image)
                                        <img src="{{ Storage::disk('supabase')->url($image->image_path) }}"
                                             @click="activeImage = '{{ $image->image_path }}'"
                                             class="w-20 h-20 object-cover rounded border-2 flex-shrink-0 cursor-pointer transition"
                                             :class="activeImage === '{{ $image->image_path }}' ? 'border-primary-600' : 'border-transparent hover:border-gray-300'">
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

                        <div class="mt-4 border-t pt-4" x-data="{ showBidForm: false, bidQty: {{ $product->minimum_order_quantity ?? 1 }}, bidPrice: '' }">
                            <button type="button" @click="showBidForm = !showBidForm"
                                class="text-sm text-accent-600 hover:underline font-semibold flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span x-text="showBidForm ? 'Cancel offer' : 'Make an Offer'"></span>
                            </button>

                            <form x-show="showBidForm" x-cloak method="POST" action="{{ route('bids.store', $product) }}" class="mt-3 border rounded-lg p-4 bg-gray-50">
                                @csrf
                                <p class="text-xs text-gray-500 mb-3">Propose a quantity and price to the farmer. They can accept or decline your offer.</p>

                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Quantity ({{ $product->unit_of_measurement }})</label>
                                        <input type="number" name="quantity" x-model.number="bidQty" min="0.01" max="{{ $product->available_quantity }}" step="0.01" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Your Offer (₱ per {{ $product->unit_of_measurement }})</label>
                                        <input type="number" name="offered_price" x-model.number="bidPrice" min="0.01" max="{{ $product->selling_price - 0.01 }}" step="0.01" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-600 mb-3">
                                    Listed price: ₱{{ number_format($product->selling_price, 2) }} ·
                                    Your total: <span class="font-semibold" x-text="'₱' + ((bidQty || 0) * (bidPrice || 0)).toFixed(2)"></span>
                                </p>

                                <textarea name="message" rows="2" placeholder="Optional message to the farmer..."
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm mb-3"></textarea>

                                @error('quantity') <p class="text-red-600 text-xs mb-2">{{ $message }}</p> @enderror
                                @error('offered_price') <p class="text-red-600 text-xs mb-2">{{ $message }}</p> @enderror

                                <button type="submit" class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                                    Send Offer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>