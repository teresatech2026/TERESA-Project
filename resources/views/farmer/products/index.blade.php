<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Products') }}
            </h2>
            <a href="{{ route('farmer.products.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-md text-sm">
                + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($products->isEmpty())
                    <p class="text-gray-500">You haven't added any products yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($products as $product)
                            <a href="{{ route('farmer.products.show', $product) }}" class="block border rounded-lg p-4 hover:shadow-md transition">
                                @if ($product->primaryImage)
                                    <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                         class="w-full h-40 object-cover rounded mb-3">
                                @else
                                    <div class="w-full h-40 bg-gray-100 rounded mb-3 flex items-center justify-center text-gray-400 text-sm">
                                        No Image
                                    </div>
                                @endif
                                <h3 class="font-semibold">{{ $product->product_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->commodity_type }} — {{ $product->category }}</p>
                                <p class="mt-1 font-medium">₱{{ number_format($product->selling_price, 2) }} / {{ $product->unit_of_measurement }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $product->available_quantity }}</p>
                                <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full
                                    {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>