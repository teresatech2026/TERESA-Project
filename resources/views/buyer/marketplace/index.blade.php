<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <form method="GET" action="{{ route('marketplace.index') }}" class="mb-6">
        <div class="relative max-w-md">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search products, commodity, or category..."
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm pr-10">
            <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-primary-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
        @if ($search)
            <p class="text-xs text-gray-500 mt-2">
                Showing results for "<strong>{{ $search }}</strong>" ·
                <a href="{{ route('marketplace.index') }}" class="text-primary-600 hover:underline">Clear search</a>
            </p>
        @endif
    </form>

    @if ($products->isEmpty())
                    <p class="text-gray-500">No products available yet. Check back soon!</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ($products as $product)
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
                                <h3 class="text-sm text-gray-700">{{ $product->product_name }}</h3>
                                <p class="text-xs text-gray-500">{{ $product->commodity_type }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    by {{ $product->farmer->full_name }} · {{ $product->farmer->barangay }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Posted {{ $product->created_at->format('M d, Y g:i A') }} ({{ $product->created_at->diffForHumans() }})
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>