<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->product_name }}
            </h2>
            <a href="{{ route('farmer.marketplace.index') }}" class="text-sm text-primary-600 hover:underline">
                &larr; Back to Marketplace
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Images (swipeable carousel) -->
                    @php
                        // Primary image first, then by sort order
                        $galleryImages = $product->images
                            ->sortBy([['is_primary', 'desc'], ['sort_order', 'asc']])
                            ->values();
                    @endphp

                    <style>
                        .gallery-track::-webkit-scrollbar { display: none; }
                    </style>

                    <div x-data="{
                            current: 0,
                            total: {{ $galleryImages->count() }},
                            go(i) {
                                i = Math.max(0, Math.min(this.total - 1, i));
                                this.$refs.track.scrollTo({ left: i * this.$refs.track.clientWidth, behavior: 'smooth' });
                            },
                            sync() {
                                this.current = Math.round(this.$refs.track.scrollLeft / this.$refs.track.clientWidth);
                            }
                         }">
                        @if ($galleryImages->isNotEmpty())
                            <div class="relative mb-3">
                                <!-- Swipeable track -->
                                <div x-ref="track" @scroll.debounce.50ms="sync()"
                                     class="gallery-track flex overflow-x-auto rounded-lg"
                                     style="scroll-snap-type: x mandatory; scrollbar-width: none; -webkit-overflow-scrolling: touch;">
                                    @foreach ($galleryImages as $image)
                                        <img src="{{ Storage::disk('supabase')->url($image->image_path) }}"
                                             alt="{{ $product->product_name }} photo {{ $loop->iteration }}"
                                             draggable="false"
                                             class="w-full h-80 object-cover flex-shrink-0"
                                             style="scroll-snap-align: center;">
                                    @endforeach
                                </div>

                                @if ($galleryImages->count() > 1)
                                    <!-- Counter (e.g. 1/3) -->
                                    <span x-text="(current + 1) + '/' + total"
                                          class="absolute text-white text-xs font-semibold px-2.5 py-1 rounded-full"
                                          style="bottom: 12px; right: 12px; background: rgba(0,0,0,0.55);"></span>

                                    <!-- Arrows (desktop only) -->
                                    <button type="button" @click="go(current - 1)" x-show="current > 0"
                                            aria-label="Previous photo"
                                            class="absolute hidden sm:flex items-center justify-center rounded-full bg-white shadow text-gray-700 hover:text-primary-600"
                                            style="left: 10px; top: 50%; transform: translateY(-50%); width: 36px; height: 36px;">
                                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <button type="button" @click="go(current + 1)" x-show="current < total - 1"
                                            aria-label="Next photo"
                                            class="absolute hidden sm:flex items-center justify-center rounded-full bg-white shadow text-gray-700 hover:text-primary-600"
                                            style="right: 10px; top: 50%; transform: translateY(-50%); width: 36px; height: 36px;">
                                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                @endif
                            </div>

                            @if ($galleryImages->count() > 1)
                                <!-- Thumbnails -->
                                <div class="flex gap-2 overflow-x-auto pb-2">
                                    @foreach ($galleryImages as $image)
                                        <img src="{{ Storage::disk('supabase')->url($image->image_path) }}"
                                             alt="Thumbnail {{ $loop->iteration }}"
                                             @click="go({{ $loop->index }})"
                                             class="w-20 h-20 object-cover rounded border-2 flex-shrink-0 cursor-pointer transition"
                                             :class="current === {{ $loop->index }} ? 'border-accent-500' : 'border-transparent hover:border-gray-300'">
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
                        <div class="block border rounded-lg p-4 mb-6 bg-gray-50">
                            <h3 class="font-semibold text-sm text-gray-500 uppercase mb-2">Sold by</h3>
                            <div class="flex items-center gap-3">
                                @if ($product->farmer->user->profile_photo_url)
                                    <img src="{{ $product->farmer->user->profile_photo_url }}" alt="{{ $product->farmer->full_name }}"
                                         class="w-10 h-10 rounded-full object-cover border-2 border-accent-500">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-700 border-2 border-accent-500 flex items-center justify-center text-sm font-semibold">
                                        {{ strtoupper(substr($product->farmer->full_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium flex items-center gap-2">
                                        {{ $product->farmer->full_name }}
                                        @if ($product->farmer->rsbsa_number)
                                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700 border border-primary-200">
                                                ✓ RSBSA
                                            </span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $product->farmer->barangay }}, {{ $product->farmer->municipality }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
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

                        @if ($product->farmer_id === $myFarmerId)
                            <div class="border-t pt-4">
                                <a href="{{ route('farmer.products.show', $product) }}"
                                   class="inline-block bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                                    Manage this listing
                                </a>
                            </div>
                        @else
                            <p class="border-t pt-4 text-xs text-gray-500">
                                You are viewing another farmer's listing. Only buyers can purchase or send offers.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>