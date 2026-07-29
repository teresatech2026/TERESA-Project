<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($products->isEmpty())
                    <p class="text-gray-500">No products available yet. Check back soon!</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ($products as $product)
                            <a href="{{ route('marketplace.show', $product) }}" class="block border border-primary-600 rounded-lg p-4 hover:shadow-md transition">
                                @if ($product->primaryImage)
                                    <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                         class="w-full h-32 object-cover rounded mb-3">
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded mb-3 flex items-center justify-center text-gray-400 text-sm">
                                        No Image
                                    </div>
                                @endif
                                <h3 class="font-semibold">{{ $product->product_name }}</h3>
                                <p class="text-xs text-gray-500">{{ $product->commodity_type }}</p>
                                <p class="mt-1 font-medium">₱{{ number_format($product->selling_price, 2) }} / {{ $product->unit_of_measurement }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    by {{ $product->farmer->full_name }} · {{ $product->farmer->barangay }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>